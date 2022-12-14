<?php

namespace app\models;


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
 * @property Images $img изображение слайда
 * @property Images $imgPath изображение слайда
 * @property array $slidesPath путь к слайдам
 * @property integer $sort путь к слайдам
 * @property UploadedFile imgFile
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
    const  IS_ACTIVE = 1;
    const  NOT_ACTIVE = 0;

    const POSITION_DEFAULT = 'cover';
    private $md5;

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
            [['img_id', 'status', 'sort'], 'integer'],
            [['type'], 'required'],
            [['content_options', 'added_date'], 'safe'],
            [['type'], 'string', 'max' => 30],
            [['content'], 'string', 'max' => 250],
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
            'status' => 'Активность',
            'content_options' => 'параметры контента',
            'content' => 'контент',
            'added_date' => 'дата добавления',
            'sort' => 'Сортировка',
            'imgPath' => 'Картинка'
        ];
    }

    public function getImgFile()
    {
        return Images::getImgPathById($this->img_id);
    }

    public function setImgFile($imgFile)
    {
        $file = UploadedFile::getInstance($this, 'imgFile');
        if ($file) {
            $image = new Images(['dir' => 'slider/menu/']);
            $this->img_id = $image->upload($file);
        }
        return $imgFile;
    }

    public static function getMainSlides()
    {
        $slidesPath = [];
        $slidesIds = self::find()
            ->where(['type' => self::TYPE_MAIN_SLIDER])
            ->andWhere(['status' => self::IS_ACTIVE])
            ->select(['img_id'])
            ->orderBy(['sort' => SORT_ASC])
            ->column();
        $images = Images::find()
            ->where(['id' => $slidesIds])
            ->select(['path', 'name', 'id'])
            ->indexBy('id')
            ->all();
        /**@var Images $img * */
        /**@var array $slidesPath * */
        foreach ($slidesIds as $imgId) {
            $slidesPath[] = $images[$imgId]->fullPath;
        }
        return $slidesPath;
    }

    public function getImgSize()
    {
        return ($img = $this->img) ? $img->size : '';
    }

    public function getImg()
    {
        return $this->hasOne(Images::class, ['id' => 'img_id']);
    }

    public function getImgPath()
    {
        return ($this->img) ? $this->img->fullPath : null;
    }

    public static function getStatusList(): array
    {
        return [
            self::NOT_ACTIVE => 'не активен',
            self::IS_ACTIVE => 'активен'
        ];
    }

    public static function getStatusName($value) {
        return self::getStatusList()[$value];
    }

    public static function getTypeList(): array
    {
        return [
            self::TYPE_MAIN_SLIDER => 'слайдер',
        ];
    }

    public function getSliderPosition() {
        $co = $this->content_options;
        if (!empty($co) && !empty($co['slider']) && !empty($co['slider']['css'] && !empty($co['slider']['css']['position']))){
            return $co['slider']['css']['position'];
        }
        return self::POSITION_DEFAULT;
    }

}
