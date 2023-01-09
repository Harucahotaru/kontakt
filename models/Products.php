<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name Наименование товара
 * @property string|null $description Описание товара
 * @property int $cost Цена
 * @property int $on_sale Статус скидки(1-есть, 0-нету)
 * @property int|null $sale Скидка
 * @property int|null $img_id Изображение
 * @property string|null $category_id id категории
 * @property string $parent_id id подходящих товаров
 * @property string|null $date_c Дата создания
 * @property string|null $date_m Дата изменения
 * @property int $active Активность
 * @property int $article Артикул
 * @property int $brand_id Id бренда
 */
class Products extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;
    const IS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_c',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'date_m',
                ],
                'value' => function () {
                    return Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s');
                },
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                'imgFile',
                'image',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'checkExtensionByMimeType' => true,
                'maxFiles' => 10,
                'maxSize' => 1024 * 1024 * 1000,
                'tooBig' => 'Limit is 5 MB'
            ],
            [['name', 'cost'], 'required'],
            [['cost', 'on_sale', 'sale', 'active', 'brand_id'], 'integer'],
            [['date_c', 'date_m'], 'safe'],
            [['description', 'parent_id'], 'string'],
            [['name', 'category_id', 'article'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование товара',
            'description' => 'Описание товара',
            'cost' => 'Цена',
            'on_sale' => 'Статус скидки',
            'sale' => 'Стоимость товара со скидкой',
            'img_id' => 'Изображение',
            'category_id' => 'Категория',
            'parent_id' => 'Подходящие товары',
            'date_c' => 'Дата создания',
            'date_m' => 'Дата изменения',
            'active' => 'Активность',
            'article' => 'Артикул',
            'brand_id' => 'Производитель',
        ];
    }

    /**
     * @param int $limit
     * @return array
     */
    public static function getAllProducts(int $limit = 40): array
    {
        return self::find()->orderBy(['active' => self::IS_ACTIVE])->limit($limit)->all();
    }

    /**
     * @param $id
     *
     * @return Products
     *
     * @throws Exception
     */
    public static function getProductById($id): Products
    {
        $product = self::find()->where(['id' => $id])->one();
        if(empty($product)) {
            throw new Exception('Такого товара нет в нашей базе, извините');
        }

        return $product;
    }


    /**
     * @param int|null $categoryId
     * @return array
     */
    public static function getProductsByCategory(?int $categoryId): array
    {
        return self::find()
            ->where(['category_id' => $categoryId])
            ->andWhere(['active' => self::IS_ACTIVE])
            ->all();
    }

    /**
     * @param int|null $pagination
     * @return ActiveDataProvider
     */
    public static function getAllProductsProvider(?int $pagination = 20): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => self::find(),
            'pagination' => [
                'pageSize' => $pagination,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date_c' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * @param int|null $pagination
     * @param int|null $catalogId
     * @return ActiveDataProvider
     */
    public static function getProductsByCategoryProvider(?int $pagination = 20, ?int $categoryId = null): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => self::find()->where(['category_id' => $categoryId]),
            'pagination' => [
                'pageSize' => $pagination,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date_c' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * @return string|null
     */
    public function getImgFile()
    {
        return Images::getImgPathById($this->img_id);
    }

    /**
     * @param $imgFile
     * @return mixed
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function setImgFile($imgFile)
    {
        $files = UploadedFile::getInstances($this, 'imgFile');
        if ($files) {
            foreach ($files as $file) {
                $image = new Images([
                    'dir' => 'products/',
                    'createPrew' => true,
                ]);
                $imagesIds[] = $image->upload($file);
            }

            $productImgs = new ProductsImgs();
            $productImgs->imgs_ids = json_encode($imagesIds);
            $productImgs->main_img_id = $imagesIds[0];
            $productImgs->save();
            $this->img_id = $productImgs->id;
        }

        return $imgFile;
    }

    /**
     * @return array
     */
    public function getImagesPath(): array
    {
        $imagesPath = [];
        $imagesIds = ProductsImgs::findOne(['id' => $this->img_id]);
        if($imagesIds) {
            $images = Images::find()->where(['id' => json_decode($imagesIds->imgs_ids)])->all();
            foreach ($images as $image) {
                $imagesPath[] = $image->getFullPath();
            }
        }

        return $imagesPath;
    }

    /**
     * @return array
     */
    public function getThumbnailsPath(): array
    {
        $iThumbnailsPath = [];
        $imagesIds = ProductsImgs::findOne(['id' => $this->img_id]);
        if($imagesIds) {
            $images = Images::find()->where(['id' => json_decode($imagesIds->imgs_ids)])->all();
            foreach ($images as $image) {
                $iThumbnailsPath[] = $image->getThumbnailsFullPath();
            }
        }

        return $iThumbnailsPath;
    }

    /**
     * @return string|null
     */
    public function getMainImagePath(): ?string
    {
        $imagesIds = ProductsImgs::findOne(['id' => $this->img_id]);
        if (empty($imagesIds)) {
            return '';
        }
        $image = Images::find()->where(['id' => json_decode($imagesIds->main_img_id)])->one();
        if (!$image) {
            return $imagesIds->main_img_id;
        }

        return $image->getFullPath();
    }

    /**
     * @return string[]
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_DISABLE => 'Не активен',
        ];
    }

    /**
     * @return string[]
     */
    public static function getSaleStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Есть скидка',
            self::STATUS_DISABLE => 'Нет скидки',
        ];
    }

    /**
     * @param array $parentIds
     * @return array
     */
    public function getParentProductsList(bool $onlySelectedIds = false): array
    {
        $sql = self::find();
        if ($onlySelectedIds) {
            $sql->where(['id' => $this->parent_id]);
        }
        $products = $sql->all();

        if (empty($products)) {
            return [];
        }
        /** @var Products $product */
        foreach ($products as $product) {
            $productsList[$product->id] = $product->name;
        }

        return $productsList;
    }

    public static function getParentProducts(array $parentIds): array
    {
        $products = self::find()->where(['id' => $parentIds])->all();

        return !empty($products) ? $products : [];
    }

    /**
     * @param $parentIds
     * @return ActiveDataProvider
     */
    public static function getParentProductsProvider($parentIds): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => self::find()->where(['id' => $parentIds]),
            'pagination' => [
                'pageSize' => 4,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date_c' => SORT_DESC,
                ]
            ],
        ]);
    }
}
