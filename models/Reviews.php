<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id Id отзыва
 * @property int $user_id Id пользователя
 * @property int $entity_id Id сущности
 * @property int $type Тип сущности
 * @property string|null $experience Опыт
 * @property string|null $benefits Преимущества
 * @property string|null $limitations Недостатки
 * @property string|null $content Содержание
 * @property int|null $rate Оценка
 * @property int|null $visible Видимость
 * @property string|null $date_c Дата создания
 * @property string|null $date_m Дата изменения
 * @property boolean $accepted Подтверждение комментария
 */
class Reviews extends \yii\db\ActiveRecord
{
    public const REVIEW_STATUS_ACCEPTED = true;
    public const REVIEW_STATUS_CLOSED = false;
    public const REVIEW_TYPE_PRODUCTS = 1;
    public const REVIEW_TYPE_NEWS = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_c',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'date_m',
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
            [['user_id', 'entity_id', 'type', 'accepted', 'rate', 'experience'], 'required', 'message' => '{attribute} не может быть пустой'],
            [['user_id', 'entity_id', 'type', 'rate', 'visible'], 'integer'],
            [['experience', 'benefits', 'limitations', 'content'], 'string'],
            [['date_c', 'date_m'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id отзыва',
            'user_id' => 'Id пользователя',
            'entity_id' => 'Id сущности',
            'type' => 'Тип сущности',
            'experience' => 'Опыт',
            'benefits' => 'Преимущества',
            'limitations' => 'Недостатки',
            'content' => 'Содержание',
            'rate' => 'Оценка',
            'accepted' => 'Подтверждение комментария',
            'visible' => 'Видимость',
            'date_c' => 'Дата создания',
            'date_m' => 'Дата изменения',
        ];
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return User::find()->where(['id' => $this->user_id])->select('username')->one()->getAttribute('username');
    }

    public function getExperience(): string
    {
        return Products::UseTermList()[$this->experience];
    }

    public static function getReviewsByEntityId($entityId, $entityType): ?array
    {
        return self::find()->where(['entity_id' => $entityId, 'type' => $entityType])->all();
    }

    /**
     * @param int $type
     * @param int $entityId
     *
     * @return ActiveDataProvider
     */
    public static function getReviewsProvider(int $type, int $entityId): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => self::find()->where(['entity_id' => $entityId, 'type' => $type]),
            'pagination' => [
                'pageSize' => 6,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date_c' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * Проверка отзыва на возможность отображения
     *
     * @return bool
     */
    public function checkAccessStatus(): bool
    {
        if ($this->accepted == 0 && Yii::$app->user->id !== $this->user_id) {
            return false;
        }

        return true;
    }
}