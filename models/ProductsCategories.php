<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_categories".
 *
 * @property int $id Id категории
 * @property string $name Название категории
 * @property string $url_name Название для адресной строки
 * @property int|null $is_main_category Является ли категория главной
 * @property string|null $parent_id Связанная категория
 * @property string|null $icon Картинка для меню
 */
class ProductsCategories extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 0;
    const MAIN_CATEGORY = 1;
    const NOT_MAIN_CATEGORY = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url_name'], 'required'],
            [['is_main_category', 'parent_id'], 'integer'],
            [['name', 'url_name', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id категории',
            'name' => 'Название категории',
            'url_name' => 'Название для адресной строки',
            'is_main_category' => 'Является ли категория главной',
            'parent_id' => 'Связанная категория',
            'icon' => 'Картинка для меню',
        ];
    }

    /**
     * @return array
     */
    public static function getAllCategories(): array
    {
        if ($categories = (new ProductsCategories)->getMainCategories()) {
            /** @var ProductsCategories $category */
            foreach ($categories as &$category) {
                $category['parent_id'] = self::getParentCategories($category['id']);
                if (!empty($category['parent_id'])) {
                    foreach ($category['parent_id'] as &$parentCategory) {
                        $parentCategory['parent_id'] = self::getParentCategories($parentCategory['id']);
                    }
                }
            }
        }

        return $categories;
    }

    /**
     * @return array
     */
    public static function getAllCategoriesList(): array
    {
        $categories = self::find()->all();

        if (empty($categories)) {
            return [];
        }

        /** @var ProductsCategories $category */
        foreach ($categories as $category) {
            $categoriesList[$category->id] = $category->name;
        }

        return $categoriesList;
    }

    /**
     * @param int $parentId
     * @return array
     */
    public static function getParentCategories(int $parentId): array
    {
        return self::find()->where(['parent_id' => $parentId])->asArray()->all();
    }

    /**
     * @return array
     */
    public function getMainCategories(): array
    {
        return self::find()->where(['is_main_category' => self::MAIN_CATEGORY])->asArray()->all();
    }

    /**
     * @return string[]
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Главная',
            self::STATUS_DISABLE => 'Подкатегория',
        ];
    }

    /**
     * @param string $name
     * @return static|null
     */
    public static function getByName(string $name): ?self
    {
        return self::find()->where(['url_name' => $name])->one();
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        return self::find()->where(['id' => $id])->one();
    }

    /**
     * @param $id
     * @param $breadCrumbs
     * @return array|mixed
     */
    public function getBreadCrumbs($id = null, $breadCrumbs = [])
    {
        $model = ($id !== null) ? self::findOne(['id' => $id]) : $this;
        $breadCrumbs[] = ['label' => $model->name, 'url' => $model->url_name];

        if ($model->parent_id !== null) {
            $breadCrumbs = $this->getBreadCrumbs($model->parent_id, $breadCrumbs);
        } else {
            $breadCrumbs[] = ['label' => 'Каталог', 'url' => '/catalog'];
        }
        $breadCrumbs[0] = ['label' => $breadCrumbs[0]['label']];

        return $breadCrumbs;
    }
}
