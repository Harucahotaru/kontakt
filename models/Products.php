<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name наименование товара
 * @property string|null $description описание товара
 * @property int $cost цена товара
 * @property int $on_sale статус скидки
 * @property int|null $sale размер скиидки на товар
 * @property int|null $img_id id изображения
 * @property string|null $category_id id категории
 * @property string $parent_id id подходящих товаров
 * @property string|null $date_c Дата создания
 * @property string|null $date_m Дата изменения
 * @property int $active Активность
 */
class Products extends \yii\db\ActiveRecord
{
    const IS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cost', 'parent_id'], 'required'],
            [['cost', 'on_sale', 'sale', 'img_id', 'active'], 'integer'],
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
            'name' => 'наименование товара',
            'description' => 'описание товара',
            'cost' => 'цена товара',
            'on_sale' => 'статус скидки',
            'sale' => 'размер скиидки на товар',
            'img_id' => 'id изображения',
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

    public static function getProductsByCategory(int $categoryId): array
    {
        return self::find()
            ->where(['category_id' => $categoryId])
            ->andWhere(['active' => self::IS_ACTIVE])
            ->all();
    }

    public static function getProductCategory()
    {

    }

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
}
