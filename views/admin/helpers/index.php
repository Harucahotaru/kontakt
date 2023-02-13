<?php

use app\models\Helpers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\HelpersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Подсказки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="helpers-index container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать подсказку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'label',
            'content:ntext',
            'url:url',
            'type',
            'item',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Helpers $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
