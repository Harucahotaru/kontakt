<?php

use app\models\Slider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Слайды';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container slider-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать новый слайд', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'html',
                'value' => function ($data) {
                    return Html::img($data->imgPath, ['style' => 'max-width: 250px']);
                }
            ],
            'sort',
//            'content_options',
//            'content',
        [
            'attribute' => 'added_date',
            'format' => ['datetime', 'php:d.m.Y H:i:s']
        ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Slider $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>
