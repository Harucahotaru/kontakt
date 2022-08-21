<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * This is the model class for table "news".
 *
 * @property int $id Id
 * @property string $name Название
 * @property string $url_name Url
 * @property string $content Контент
 * @property string|null $description Описание
 * @property int|null $category_id id категории
 * @property string|null $date_c Дата создания
 * @property string|null $date_m Дата изменения
 * @property int|null $c_author_id Id создавшего автора
 * @property int|null $u_author_id Id обновившего автора
 * @property int $active Активность
 * @property string|null $params Параметры
 * @property string $fullUrl Полный адрес с к новости
 * @property string $thumbarPath Путь к картинке новости
 * @property CategoryNews $category Категория новости
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url_name', 'content'], 'required'],
            [['content', 'description'], 'string'],
            [['category_id', 'c_author_id', 'u_author_id', 'active'], 'integer'],
            [['date_c', 'date_m', 'params'], 'safe'],
            [['name', 'url_name'], 'string', 'max' => 255],
            [['url_name'], 'unique'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'Id',
            'name'        => 'Название',
            'url_name'    => 'Url',
            'content'     => 'Контент',
            'description' => 'Описание',
            'category_id' => 'id категории',
            'date_c'      => 'Дата создания',
            'date_m'      => 'Дата изменения',
            'c_author_id' => 'Id создавшего автора',
            'u_author_id' => 'Id обновившего автора',
            'active'      => 'Активность',
            'params'      => 'Параметры',
        ];
    }
    
    public static function getLastNews($limit = 6): array
    {
        return self::find()->orderBy(['date_c' => SORT_DESC])->limit($limit)->all();
    }
    
    public static function getLastNewsProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query'      => self::find(),
            'pagination' => [
                'pageSize' => 6,
            ],
            'sort'       => [
                'defaultOrder' => [
                    'date_c' => SORT_DESC,
                ]
            ],
        ]);
    }
    
    public function getFullUrl()
    {
        return Url::to(["{$this->category->url_name}/$this->url_name"]);
    }
    
    public function getThumbarPath()
    {
        return 'https://mdbootstrap.com/img/new/standard/city/078.webp';
    }
    
    public function getCategory()
    {
        return $this->hasOne(CategoryNews::class, ['id' => 'category_id']);
    }
}
