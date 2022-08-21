<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_news".
 *
 * @property int $id id
 * @property string $name Название
 * @property string $url_name url
 * @property string|null $description Описание
 * @property int|null $parent_id id родительской категории
 * @property int $active Активность
 */
class CategoryNews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_news';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url_name'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'active'], 'integer'],
            [['name', 'url_name'], 'string', 'max' => 255],
            [['url_name', 'parent_id', 'active'], 'unique', 'targetAttribute' => ['url_name', 'parent_id', 'active']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'id',
            'name'        => 'Название',
            'url_name'    => 'url',
            'description' => 'Описание',
            'parent_id'   => 'id родительской категории',
            'active'      => 'Активность',
        ];
    }
}
