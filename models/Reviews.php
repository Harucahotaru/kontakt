<?php

namespace app\models;

use app\exceptions\ReviewException;
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
class Reviews extends ActiveRecord
{
    public const REVIEW_STATUS_ACCEPTED = true;
    public const REVIEW_STATUS_CLOSED = false;
    public const REVIEW_TYPE_PRODUCTS = 1;
    public const REVIEW_TYPE_NEWS = 2;
    public const REVIEW_TYPE_PRODUCTS_NAME = 'products';
    public const REVIEW_TYPE_NEWS_NAME = 'news';
    public const REVIEW_ACCEPTED = 1;
    public const REVIEW_NOT_ACCEPTED = 0;

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

    /**
     * @return string
     */
    public function getExperience(): string
    {
        return Products::UseTermList()[$this->experience];
    }

    /**
     * @param $entityId
     * @param $entityType
     * @return array|null
     */
    public static function getReviewsByEntityId($entityId, $entityType): ?array
    {
        return self::find()->where(['entity_id' => $entityId, 'type' => $entityType])->all();
    }

    /**
     * @param $reviewType
     * @param bool $onlyNotAccepted
     *
     * @return ActiveDataProvider
     *
     * @throws ReviewException
     */
    public static function getAllReviewsByTypeProvider(
        ?string $reviewType,
        bool    $onlyNotAccepted = false
    ): ActiveDataProvider
    {
        $query = self::find();

        if (!empty($reviewType)) {
            try {
                $query->where(['type' => (new Reviews)->getIntReviewType($reviewType)]);
            } catch (ReviewException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        if ($onlyNotAccepted === true) {
            $query->where(['accepted' => self::REVIEW_NOT_ACCEPTED]);
        }

        return new ActiveDataProvider([
            'query' => $query,
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
     * @throws \Exception
     */
    public function getIntReviewType($reviewType)
    {
        $intType = array_search($reviewType, self::getIntReviewTypeList());
        if (empty($intType)) {
            throw new ReviewException('неподдерживаемый тип отзывов');
        }
        return $intType;
    }

    /**
     * @return string[]
     */
    public function getIntReviewTypeList(): array
    {
        return [
            self::REVIEW_TYPE_PRODUCTS => self::REVIEW_TYPE_PRODUCTS_NAME,
            self::REVIEW_TYPE_NEWS => self::REVIEW_TYPE_NEWS_NAME,
        ];
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

    /**
     * @return $this
     */
    public function setAccepted(): self
    {
        $this->accepted = self::REVIEW_STATUS_ACCEPTED;

        return $this;
    }
}