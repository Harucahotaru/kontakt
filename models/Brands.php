<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

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
 * @property Images $img получить изображение
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
            ['imgFile', 'image',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'checkExtensionByMimeType' => true,
                'maxSize' => 1024 * 1024 * 1000,
                'tooBig' => 'Limit is 5 MB'
            ],
            [['name', 'urlname'], 'required'],
            [['urlname', 'img_id'], 'integer'],
            [['date_c', 'user_c'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['urlname'], 'unique'],
        ];
    }

    public function beforeDelete()
    {
        if ($image = Images::findOne(['id' => $this->img_id])) {
            $image->delete();
        }
        return parent::beforeDelete();
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


    public function getImgFile()
    {
        return Images::getImgPathById($this->img_id);
    }

    public function setImgFile($imgFile)
    {
        $file = UploadedFile::getInstance($this, 'imgFile');
        if ($file) {
            $image = new Images(['dir' => 'brands/']);
            $this->img_id = $image->upload($file);
        }
        return $imgFile;
    }
    
    public function getImg(){
        return $this->hasOne(Images::class,['id' => 'img_id']);
    }
    
    public function getImgPath(){
        return $this->img ? $this->img->getFullPath() : '';
    }
}
