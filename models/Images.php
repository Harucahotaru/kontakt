<?php

namespace app\models;

use app\exceptions\ImageException;
use Gumlet\ImageResize;
use Gumlet\ImageResizeException;
use Yii;
use yii\base\Exception;
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
 * @property string $thumbPath Полный путь к картинке
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

    /**
     * @param UploadedFile $imgFile
     * @return int
     *
     * @throws \yii\db\Exception|ImageException
     */
    public function upload(UploadedFile $imgFile): int
    {
        $this->name = $imgFile->name;
        $this->path = "/{$this->base_directory}{$this->dir}";
        $this->hash = md5_file($imgFile->tempName);
        if (!($imgModel = self::findOne(['hash' => $this->hash]))) {
            if (!$imgFile->saveAs("@webroot{$this->path}{$this->name}")) { // Сохраняем файл
                throw new ImageException('Не удалось сохранить картинку');
            }

            $this->size = $imgFile->size;

            if ($this->createPrew === true) {

                try {
                    $this->createThumbnails();
                } catch (ImageResizeException $e) {
                    throw new ImageException("Ошибка при создании превью", $this->errors);
                }
            }
            if (!$this->save()) {
                throw new ImageException('Ошибка сохранения изображения', $this->errors);
            }
            $imgModel = $this;
        }

        return $imgModel->id;
    }

    /**
     * @return bool
     *
     * @throws ImageResizeException
     */
    private function createThumbnails(): bool
    {
        $result = false;

        $thumbnailsPath = $this->getPreviewPath();
        $image = new ImageResize($this->thumbPath);
        $image->resize(400, 400, true);
        $image->save(Yii::getAlias('@webroot') . $thumbnailsPath, IMAGETYPE_PNG);
        $this->prew_path = $thumbnailsPath;

        if (!empty($image)) {
            $result = true;
        }
        return $result;
    }


    /**
     * @return string
     */
    private function getPreviewPath()
    {
        return '/'
            . $this->base_directory
            . $this->dir
            . $this->prewDir
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
    public function getThumbPath(): string
    {
        return substr("{$this->path}{$this->name}", 1);
    }

    /**
     * @return string
     */
    public function getFullPath(): string
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
