<?php

namespace app\models;


use app\behaviors\ImageBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "slider".
 *
 * @property int $id id слайда
 * @property int $img_id id изображения
 * @property string $type
 * @property int $status активен слайд, или нет
 * @property string|null $content_options параметры для контента
 * @property string|null $content контент для сладйа
 * @property string|null $added_date дата добавления
 */
class Slider extends ActiveRecord
{
    /**
     * VISIBLE_ON - slide is visible
     * VISIBLE_OFF- slide isn't visible
     */
    const VISIBLE_ON = 1;
    const VISIBLE_OFF = 0;
    /**
     * TYPE_MAIN_SLIDER - main slider
     */
    const TYPE_MAIN_SLIDER = 1;
    const  SLIDE_IS_ACTIVE = 1;
    private $md5;
    public $imgFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    public function behaviors()
    {
        return [
//            'imageBehavior' => [
//                'class' => ImageBehavior::class,
//                'imageAttribute' => 'image',  //Attribute of model which using to upload image
//                'uploadPath' => '@webroot/uploads',  //Path to upload dir
//                'uploadUrl' => '@web/uploads',  //Url to upload dir
//            ],
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'added_date',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'added_date',
                ],
                'value' => function () {
                    return Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s');
                },
            ]
        ];
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
            [['type'], 'required'],
            [['status', 'img_id'], 'integer'],
            [['type'], 'string', 'max' => 30],
            [['content_options'], 'string', 'max' => 50],
            [['added_date'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'type' => 'Тип',
            'img_id' => 'id изображения',
            'status' => 'Активност(0,1)',
            'content_options' => 'параметры контента',
            'content' => 'контент',
            'added_date' => 'дата добавления',
        ];
    }

    public static function getMainSlides()
    {
        $slidesId = self::find()
            ->where(['type' => self::TYPE_MAIN_SLIDER])
            ->andWhere(['status' => self::SLIDE_IS_ACTIVE])
            ->select(['img_id'])
            ->column();
        $slidesPath = Images::find()
            ->where(['id' => $slidesId])
            ->select(['project_path'])
            ->column();
        return $slidesPath;
    }

    public function saveImg()
    {
        $this->imgFile = UploadedFile::getInstance($this, 'imgFile');
        $image = new Images(['base_path' => 'slider/menu/']);
        $this->img_id = $image->upload($this->imgFile);
        $this->imgFile = null;
        return true;
    }
}
