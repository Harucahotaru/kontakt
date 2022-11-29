<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pages_content".
 *
 * @property int $id
 * @property string $page_id
 * @property string|null $content
 * @property int|null $active
 */
class PagesContent extends \yii\db\ActiveRecord
{
    public const IS_ACTIVE = 1;
    public const IS_NOT_ACTIVE = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id'], 'required'],
            [['content'], 'string'],
            [['active'], 'integer'],
            [['page_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'content' => 'Content',
            'active' => 'Active',
        ];
    }
}
