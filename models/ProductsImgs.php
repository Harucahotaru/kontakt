<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_imgs".
 *
 * @property int $id
 * @property int|null $main_img_id Id главного изоображения
 * @property string|null $imgs_ids Id изображений
 */
class ProductsImgs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_imgs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_img_id'], 'integer'],
            [['imgs_ids'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_img_id' => 'Id главного изоображения',
            'imgs_ids' => 'Id изображений',
        ];
    }
}
