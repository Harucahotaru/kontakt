<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
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
            ['imgFile', 'image',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'checkExtensionByMimeType' => true,
                'maxSize' => 1024 * 1024 * 1000,
                'tooBig' => 'Limit is 5 MB'
            ],
            [['name', 'cost', 'parent_id'], 'required'],
            [['cost', 'on_sale', 'sale', 'active'], 'integer'],
            [['date_c', 'date_m'], 'safe'],
            [['name', 'description', 'category_id', 'parent_id'], 'string', 'max' => 255],
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
            'sale' => 'Скидка',
            'img_id' => 'Изображение',
            'category_id' => 'id категории',
            'parent_id' => 'id подходящих товаров',
            'date_c' => 'Дата создания',
            'date_m' => 'Дата изменения',
            'active' => 'Активность',
        ];
    }

    public static function getAllProducts($limit = 20): array
    {
        return self::find()->orderBy(['active' => self::IS_ACTIVE])->limit($limit)->all();
    }

    /**
     * @param int $categoryId
     * @return array
     */
    public static function getProductsByCategory(int $categoryId): array
    {
        return self::find()
            ->where(['category_id' => $categoryId])
            ->andWhere(['active' => self::IS_ACTIVE])
            ->all();
    }

    /**
     * @return ActiveDataProvider
     */
    public static function getAllProductsProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => self::find(),
            'pagination' => [
                'pageSize' => 20,
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
        $file = UploadedFile::getInstance($this, 'imgFile');
        if ($file) {
            $image = new Images(['dir' => 'products/']);
            $this->img_id = $image->upload($file);
        }
        return $imgFile;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImg()
    {
        return $this->hasOne(Images::class, ['id' => 'img_id']);
    }

    /**
     * @return string
     */
    public function getImgPath()
    {
        return $this->img ? $this->img->getFullPath() : '';
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_DISABLE => 'Не активен',
        ];
    }

    public static function getSaleStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Есть скидка',
            self::STATUS_DISABLE => 'Нет скидки',
        ];
    }
}
