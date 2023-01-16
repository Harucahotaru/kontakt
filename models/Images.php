<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\imagine\Image;
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
 * @property string $prew_path Путь к превью
 */
class Images extends \yii\db\ActiveRecord
{
    //public $imgFile;
    public string $base_directory = 'upload/images/';

    public string $dir = '';

    public bool $createPrew = false;

    public string $prewDir = 'thubnails/';


    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'images';
    }

    public function beforeDelete()
    {
        return unlink(Yii::getAlias('@webroot') . "{$this->path}{$this->name}");
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
                'tooBig' => 'Limit is 1 GB'
            ],
            [['path', 'hash'], 'required'],
            [['size'], 'integer'],
            [['date_c', 'prew_path'], 'safe'],
            [['description', 'imgDir', 'hash', 'name'], 'string', 'max' => 255],
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
            'prew_path' => 'Путь к превью',
        ];
    }

    public function upload(UploadedFile $imgFile): int
    {
        $this->name = $imgFile->name;
        $this->path = "/{$this->base_directory}{$this->dir}";
        $this->hash = md5_file($imgFile->tempName);
        if (!($imgModel = self::findOne(['hash' => $this->hash]))) {
            if (!$imgFile->saveAs("@webroot{$this->path}{$this->name}")) { // Сохраняем файл
                throw new Exception('Не удалось сохранить картинку');
            }

            $this->size = $imgFile->size;

//            if ($this->createPrew === true) {
//                $this->createThumbnails();
//            }
            if (!$this->save()) {
                throw new \yii\db\Exception('Ошибка сохранения изображения', $this->errors);
            }
            $imgModel = $this;
        }
        return $imgModel->id;
    }

    /**
     * @return bool
     */
    private function createThumbnails(): bool
    {
        $thumbnailsPath = $this->getPreviewPath();
        Image::thumbnail($this->fullPath, 400, 400)
            ->save(
                Yii::getAlias('@webroot') . $thumbnailsPath,
                ['quality' => 80]
            );

        $this->prew_path = $thumbnailsPath;

        return true;
    }
    /**
     * @return string
     */
    private function getPreviewPath()
    {
        return '/'
            . $this->base_directory
            . $this->dir
            . $this-> prewDir
            . $this->name;
    }

    /**
     * @return string
     */
    public function getThumbnailsFullPath(): string
    {
        return Yii::getAlias('@web') . $this->prew_path;
    }

    /**
     * @return string
     */
    public function getFullPath():string
    {
        return URL::to(Yii::getAlias('@web') . "{$this->path}{$this->name}", true);
    }

    /**
     * @param int|null $id
     * @return string|null
     */
    public static function getImgPathById(?int $id): ?string
    {
        return ($img = self::findone(['id' => $id])) ? $img->fullPath : null;
    }

    /**
     * @param $imgFile
     * @return mixed
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function setImgFile($imgFile)
    {
        $file = UploadedFile::getInstance($this, 'imgFile');
        if ($file) {
            $image = new Images(['dir' => 'slider/menu/']);
            $image->upload($file);
        }
        return $imgFile;
    }

    public function getImgFile()
    {
        echo 123;
    }

    /**
     * @return mixed|string
     */
    public function getImgDir()
    {

        $res = '';
        if (!empty($this->path)) {
            preg_match('/upload\/images\/(.*)/', $this->path, $matches);
            $res = $matches[1] ?? '';
        }
        return $res;
    }

    /**
     * @param $imgDir
     * @return string
     */
    public function setImgDir($imgDir)
    {
        $this->dir = $imgDir;
        return $this->dir;
    }
}
