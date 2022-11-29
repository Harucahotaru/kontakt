<?php

namespace app\models;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $url
 * @property string $name
 * @property int|null $active
 * @property PagesContent $pagesContent
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                SaveRelationsBehavior::class => [
                    'class' => SaveRelationsBehavior::class,
                    'relations' => [
                        'pagesContent',
                    ],
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'name'], 'required'],
            [['active'], 'integer'],
            [['url', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'name' => 'Name',
            'active' => 'Active',
        ];
    }

    public function getPagesContent()
    {
        return $this->hasMany(PagesContent::class, ['page_id' => 'id'])->andWhere(['pages_content.active' => PagesContent::IS_ACTIVE]);
    }
}
