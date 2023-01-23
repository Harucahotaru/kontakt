<?php

use app\models\Brands;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BrandsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model Brands */

$this->title = 'Производители';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container brands-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить производителя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img($model->ImgPath, ['style' => 'max-width: 100px']);
                }
            ],
            'name',
            'description',
            'urlname',
            'date_c',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Brands $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
