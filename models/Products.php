<?php

namespace app\models;

use app\classes\Dropdown;
use app\classes\RecommendedProducts;
use app\exceptions\ProductException;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name Наименование товара
 * @property string|null $description Описание товара
 * @property int $currency Цена
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

    const NEW_PRODUCTS_PERIOD_DAYS = 30;

    const ACTION_DELETE = 'delete';

    const ACTION_CHANGE_CATEGORY = 'change_category';

    const ACTION_SALE_STATUS = 'change_sale_status';

    const ACTION_CHANGE_PROMOTION = 'change_promotion';

    const ACTION_CHANGE_ACTIVE = 'change_active';

    const BASE_PAGINATION = 40;

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
            [['name'], 'required'],
            [['on_sale', 'sale', 'active', 'brand_id'], 'integer'],
            [['currency'], 'double'],
            [['date_c', 'date_m'], 'safe'],
            ['parent_id', 'each', 'rule' => ['integer']],
            [['description'], 'string'],
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
            'name' => 'Наименование',
            'description' => 'Описание товара',
            'currency' => 'Цена',
            'on_sale' => 'Статус скидки',
            'sale' => 'Цена со скидкой',
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

    public function getActiveFields(): array
    {
        return [
            'name' => 'Наименование товара',
            'description' => 'Описание товара',
            'currency' => 'Цена',
            'on_sale' => 'Статус скидки',
            'sale' => 'Скидка',
            'category_id' => 'id категории',
            'parent_id' => 'id подходящих товаров',
            'article' => 'Артикул'
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
        if (empty($product)) {
            throw new Exception('Такого товара нет в нашей базе, извините');
        }

        return $product;
    }

    /**
     * @param $ids
     * @return array
     *
     * @throws Exception
     */
    public static function getProductByIds($ids): array
    {
        $product = self::find()->where(['id' => $ids])->all();
        if (empty($product)) {
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
     *
     * @return ActiveQuery
     */
    public static function getAllProductsProvider(): ActiveQuery
    {
        return self::find();
    }

    /**
     * @param int|null $categoryId
     *
     * @return ActiveQuery
     */
    public static function getProductsByCategoryProvider(?int $categoryId = null): ActiveQuery
    {
        return self::find()->where(['category_id' => $categoryId]);
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
        if ($imagesIds) {
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
        if ($imagesIds) {
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

    public function getRate()
    {
        $rateSum = 0;

        $reviews = $this->getProductReviews();
        if (empty($reviews)) {
            return 0;
        }
        /** @var Reviews $review */
        foreach ($reviews as $review) {
            $rateSum += $review->rate;
        }
        return $rateSum / count($reviews);
    }

    /**
     * @return array|null
     */
    public function getProductReviews(): ?array
    {
        return Reviews::getReviewsByEntityId($this->id, Reviews::REVIEW_TYPE_PRODUCTS);
    }

    /**
     * @return int
     */
    public function getReviewsCount(): int
    {
        return count($this->getProductReviews());
    }

    /**
     * @return array
     */
    public static function UseTermList(): array
    {
        return [
            'Менее месяца',
            'Менее 5 месяцев',
            'Менее года',
            'Более 2 лет',
        ];
    }

    public static function getSearchList(string $searchString = ''): string
    {
        $searchList = [];

        $query = self::find();
        if (!empty($searchString)) {
            $query->filterWhere(['like', 'name', $searchString]);
        }
        $products = $query->all();

        /** @var Products $product */
        foreach ($products as $product) {
            $searchList[] = ['value' => $product->name, 'url' => "/catalog/view/$product->id"];
        }

        return json_encode($searchList);
    }

    public static function addSortToQuery(ActiveQuery $query, array $sort): ActiveQuery
    {
        foreach ($sort as $name => $item) {
            switch ($name) {
                case 'sort_type':
                    if (!empty($item)) {
                        $query = Products::sortBySortType($query, $item);
                    }
                    break;
                case 'in_stock':
                    break;
                case 'cost':
                    if (!empty($item['from'])) {
                        $query->andWhere(['>=', 'currency', $item['from']]);
                    }
                    if (!empty($item['to'])) {
                        $query->andWhere(['<=', 'currency', $item['to']]);
                    }
                    break;
                case 'brand':
                    if (!empty($item)) {
                        $query->where(['brand_id' => $item]);
                    }
                    break;
            }
        }

        return $query;
    }

    /**
     * @param ActiveQuery $query
     * @param string $item
     *
     * @return ActiveQuery
     */
    public static function sortBySortType(ActiveQuery $query, string $item): ActiveQuery
    {
        switch ($item) {
            case 'new':
                $query->orderBy('date_c DESC');
                break;
            case 'popularity':
                $query->leftJoin('reviews', 'reviews.entity_id = products.id')
                    ->select(['COUNT(reviews.id) as cnt', 'products.*'])
                    ->groupBy('products.id')
                    ->orderBy('cnt DESC');
                break;
            case 'cost_desc':
                $query->select(['products.*', new Expression('IF(products.on_sale = 0, products.currency, products.sale) as settlement_price')])
                    ->orderBy('settlement_price DESC');
                break;
            case 'cost_asc':
                $query->select(['products.*', new Expression('IF(products.on_sale = 0, products.currency, products.sale) as settlement_price')])
                    ->orderBy('settlement_price ASC');
                break;
        }

        return $query;
    }

    /**
     * @param string $searchString
     *
     * @return ActiveQuery
     */
    public static function getProductsBySearchProvider(string $searchString): ActiveQuery
    {
        $categories = ProductsCategories::find()
            ->select(['id'])
            ->filterWhere(['like', 'name', $searchString])
            ->asArray()
            ->column();
        if (!empty($categories)) {
            $query = self::find()->where(['category_id' => $categories]);
        } else {
            $query = self::find()->filterWhere(['like', 'name', $searchString]);
        }

        return $query;
    }

    /**
     * @param string $categoryName
     * @return ActiveQuery
     *
     * @throws ProductException
     */
    public static function getProductsBySystemCategoryProvider(string $categoryName): ActiveQuery
    {
        switch ($categoryName) {
            case 'new-products':
                $query = self::find()->where(['>=', 'products.date_c', (new Products)->getNewProductsLastDay()]);
                break;
            case 'sale':
                $query = self::find()->where(['on_sale' => self::STATUS_ACTIVE]);
                break;
            case 'handshake':
                $query = self::find()->where(['category_id' => RecommendedProducts::getViewedCategories()]);
                break;
            default:
                $query = self::find();
                break;
        }

        return $query;
    }

    /**
     * @param int $brandId
     *
     * @return ActiveQuery
     */
    public static function getProductsByBrandProvider(int $brandId): ActiveQuery
    {
        return  self::find()->where(['brand_id' => $brandId]);
    }

    /**
     * Получение крайней даты для статуса товара "новинка"
     *
     * @return false|string
     *
     * @throws ProductException
     */
    private function getNewProductsLastDay(): string
    {
        $time = time();
        $time -= (self::NEW_PRODUCTS_PERIOD_DAYS * 24 * 60 * 60);

        if (!$time) {
            throw new ProductException('Ошибка при поиске товара, некоренная дата');
        }

        return date('Y-m-d h:i:s', $time);
    }

    public static function getCartProductsProvider(int $userId, ?int $pagination = self::BASE_PAGINATION): ActiveDataProvider
    {
        $productsIds = UserBasket::find()->select('products_ids')->where(['user_id' => $userId])->one();
        $productsIds = array_keys(json_decode($productsIds->products_ids, true));

        return new ActiveDataProvider([
            'query' => self::find()->where(['id' => $productsIds]),
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

    public static function actionList()
    {
        return [
            self::ACTION_DELETE => 'Удаление',
            self::ACTION_SALE_STATUS => 'Изменить статус скидки',
            self::ACTION_CHANGE_CATEGORY => 'Изменить категорию',
            self::ACTION_CHANGE_ACTIVE => 'Изменить статус товара',
//            self::ACTION_CHANGE_PROMOTION => 'Изменить акцию',
        ];
    }

    public static function paginationList()
    {
        return [
            20 => 20,
            40 => 40,
            80 => 80,
            100 => 100,
            200 => 200,
            400 => 400,
        ];
    }

    public static function sortList(): array
    {
        return [
            'new' => 'По новинкам',
            'popularity' => 'По популярности',
            'cost_desc' => 'По убыванию цен',
            'cost_asc' => 'По возрастанию цен',
        ];
    }
}