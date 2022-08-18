<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "images".
 *
 * @property int $id Id
 * @property string $project_path Путь
 * @property int|null $size Размер
 * @property string|null $description Описание
 * @property string|null $date_c Дата создания
 * @property string $hash Хэш
 */
class Images extends \yii\db\ActiveRecord
{
    public $imgFile;
    private $md5;
    public $base_directory = 'upload/images/';
    public $base_path = '';

    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'images';
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
            [['project_path', 'hash'], 'required'],
            [['size'], 'integer'],
            [['date_c'], 'safe'],
            [['description', 'hash'], 'string', 'max' => 255],
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
            'project_path' => 'Путь',
            'size' => 'Размер',
            'description' => 'Описание',
            'date_c' => 'Дата создания',
            'hash' => 'Хэш',
        ];
    }

    public function upload(UploadedFile $imgFile): int
    {
        $dir = $this->base_path; // Директория - должна быть создана
        $name = $this->randomFileName($imgFile->extension);
        $sitePath = '/'.$this->base_directory.$dir . $name;
        $systemPath = Yii::$app->basePath."/web/$sitePath";
        $hash = md5_file($imgFile->tempName);
        if (!($imgModel = self::findOne(['hash'=>$hash]))) {

            if (!$imgFile->saveAs($systemPath)) { // Сохраняем файл\{
                throw new Exception('неудалось сохранить картинку');
            }
            $params['size'] = $imgFile->size;
            $params['hash'] = md5_file($systemPath);
            $params['project_path'] = $sitePath;
            if (!$this->saveDb($params)) {
                throw new \yii\db\Exception('Ошибка сохранения изображения', $this->errors);
            }
            $imgModel = $this;
        }
        return $imgModel->id;
    }

    /**
     * Save image in DB
     * @param array $params params for save
     * @return bool
     */
    public function saveDb(array $params): bool
    {
        $this->hash = $params['hash'];
        $this->size = $params['size'];
        $this->project_path = $params['project_path'];
        return $this->save();
    }

    private function randomFileName($extension = false)
    {
        $extension = $extension ? '.' . $extension : '';
        $this->md5 = md5(microtime() . rand(0, 1000));
        do {
            $name = $this->md5;
            $path = $name . $extension;
        } while (file_exists($path));
        return $path;
    }
}
