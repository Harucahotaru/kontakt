<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "controller_rules".
 *
 * @property int $id ID
 * @property string $controller_name Имя контроллера
 * @property string|null $action Имя действия
 * @property string|null $role id роли
 * @property int|null $allow Разрешить или запретить
 * @property int|null $user_creator ID пользователя создавшего правило
 * @property string|null $date_m Дата изменения
 */
class ControllerRules extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'controller_rules';
    }

    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'user_creator',
                'updatedByAttribute' => 'user_creator',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_m',
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
            [['controller_name'], 'required'],
            [['allow', 'user_creator'], 'integer'],
            [['date_m'], 'safe'],
            [['controller_name', 'action', 'role'], 'string', 'max' => 30],
            [['controller_name', 'action', 'role'], 'unique', 'targetAttribute' => ['controller_name', 'action', 'role']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller_name' => 'Имя контроллера',
            'action' => 'Имя действия',
            'role' => 'id роли',
            'allow' => 'Разрешить или запретить',
            'user_creator' => 'ID пользователя создавшего правило',
            'date_m' => 'Дата изменения',
        ];
    }

    /**
     * Получить список правил для контроллера по имени
     * @param string $controller_name
     * @return array
     */
    public static function getControllerRules(string $controller_name): array
    {
        /* @var self $modelRules */
        $modelRules = self::find()->where(['controller_name' => $controller_name])->all();
        $controllerRulesClass = new self();
        return $controllerRulesClass->createRuleList($modelRules);
    }

    /**
     * Создать список правил из массива правил. Добавить разрешение на все для админа.
     * @param array $modelRules
     * @return array
     */
    public function createRuleList(array $modelRules): array
    {
        $controllerRules = [];
        foreach ($modelRules as $modelRule) {
            /* @var self $modelRule */
            if (empty($controllerRules[$modelRule->role])) {
                $controllerRules[$modelRule->role] = [
                    'roles' => [$modelRule->role],
                    'allow' => $modelRule->allow
                ];
                ($modelRule->action) ? $controllerRules[$modelRule->role]['actions'] = [$modelRule->action] : '';
            } else {
                $controllerRules[$modelRule->role]['actions'][] = $modelRule->action;
            }
        }
        $controllerRules = $this->allowForAdmin($controllerRules);
        return $this->banForOther($controllerRules);
    }

    /** Разрешить все для админа
     * @param array $controllerRules
     * @return array
     */
    public function allowForAdmin(array $controllerRules): array
    {
        $controllerRules['admin'] = ['allow' => true, 'roles' => ['admin']];
        return $controllerRules;
    }

    /**
     * Запретить все для остальных
     * @param array $controllerRules
     * @return array
     */
    public function banForOther(array $controllerRules): array
    {
        $controllerRules['other'] = ['allow' => false];
        return $controllerRules;
    }
}
