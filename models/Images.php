<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "images".
 *
 * @property int $id Id
 * @property string $path Путь
 * @property string $name Имя картинки
 * @property int|null $size Размер
 * @property string|null $description Описание
 * @property string|null $date_c Дата создания
 * @property string $fullPath Полный веб путь к картинке
 * @property string $hash Хэш
 */
class Images extends \yii\db\ActiveRecord
{
    //public $imgFile;
    public $base_directory = 'upload/images/';
    public $dir = '';
    
    
    /**
     * {@inheritdoc}
     */
    
    public static function tableName()
    {
        return 'images';
    }
    
    public function beforeDelete(){
        return unlink(Yii::getAlias('@webroot')."{$this->path}{$this->name}");
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
            [['path', 'hash'], 'required'],
            [['size'], 'integer'],
            [['date_c'], 'safe'],
            [['description','imgDir', 'hash','name'], 'string', 'max' => 255],
            [['hash'], 'unique'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'path' => 'Путь',
            'size' => 'Размер',
            'description' => 'Описание',
            'date_c' => 'Дата создания',
            'hash' => 'Хэш',
            'name' => 'Имя картинки',
        ];
    }
    
    public function upload(UploadedFile $imgFile): int
    {
        $this->name = $imgFile->name;
        $this->path = "/{$this->base_directory}{$this->dir}";
        $this->hash = md5_file($imgFile->tempName);
        if (!($imgModel = self::findOne(['hash'=>$this->hash]))) {
            if (!$imgFile->saveAs("@webroot{$this->path}{$this->name}")) { // Сохраняем файл\{
                throw new Exception('Не удалось сохранить картинку');
            }
            $this->size = $imgFile->size;
            if (!$this->save()) {
                throw new \yii\db\Exception('Ошибка сохранения изображения', $this->errors);
            }
            $imgModel = $this;
        }
        return $imgModel->id;
    }
    
    public function getFullPath(){
        return URL::to(Yii::getAlias('@web')."{$this->path}{$this->name}",true);
    }
    
    public static function getImgPathById(?int $id) : ?string{
        return ($img = self::findone(['id' => $id])) ? $img->fullPath : null;
    }
    
    public function getImgFile(){
        //echo 123; exit;
        return 1;
    }
    
    public function setImgFile($imgFile){
        $file = UploadedFile::getInstance($this, 'imgFile');
        if ($file){
            $image = new Images(['dir' => 'slider/menu/']);
            $image->upload($file);
        }
        return $imgFile;
    }
    
    public function getImgDir(){
        
        $res='';
        if (!empty($this->path)){
            preg_match('/upload\/images\/(.*)/',$this->path,$matches);
            $res = $matches[1] ?? '';
        }
        return $res;
    }
    
    public function setImgDir($imgDir){
        $this->dir = $imgDir;
        return $this->dir;
    }
}
