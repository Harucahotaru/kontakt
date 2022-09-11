<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brands".
 *
 * @property int $id Id
 * @property string $name Путь
 * @property string|null $description Описание
 * @property int $urlname Размер
 * @property string|null $date_c Дата создания
 * @property string|null $user_c Дата создания
 * @property int|null $img_id ID изображения
 * @property string $img получить изображение
 * @property string $imgPath получить путь к изображению
 */
class Brands extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brands';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'urlname'], 'required'],
            [['urlname', 'img_id'], 'integer'],
            [['date_c', 'user_c'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['urlname'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'name' => 'Путь',
            'description' => 'Описание',
            'urlname' => 'Размер',
            'date_c' => 'Дата создания',
            'user_c' => 'Дата создания',
            'img_id' => 'ID изображения',
        ];
    }
    
    public static function getBrandList(){
        return self::find()->all();
    }
    
    public function getImg(){
        return false;
    }
    
    public function getImgPath(){
        return 'https://legrand.ru/upload/upfails/press/corporate-identity/Legrand_logo_social.jpg';
    }
}
