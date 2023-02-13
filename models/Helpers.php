<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "helpers".
 *
 * @property int $id Id
 * @property string|null $label Название подсказки
 * @property string|null $content Содержание подсказки
 * @property string|null $url Адрес подсказки
 * @property int|null $type Тип подсказки
 * @property string|null $item Элемент подсказки
 */
class Helpers extends \yii\db\ActiveRecord
{

    public const MAIN_HELPER = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'helpers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['type'], 'integer'],
            [['date_c'], 'safe'],
            [['label', 'url', 'item'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_c',
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
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'label' => 'Название подсказки',
            'content' => 'Содержание подсказки',
            'url' => 'Адрес подсказки',
            'type' => 'Тип подсказки',
            'item' => 'Элемент подсказки',
        ];
    }

    /**
     * @param string $url
     *
     * @return array
     */
    public static function getByUrl(string $url): array
    {
        $url = str_replace('/index', '', $url);

        return self::find()->where(['url' => $url])->all();
    }

    public static function getHelpersTypeList()
    {
        return [
            self::MAIN_HELPER => 'Основная подсказка',
        ];
    }
}
