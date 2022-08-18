<?php

use app\models\ControllerRules;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ControllerRulesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Controller Rules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="controller-rules-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Controller Rules', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'controller_name',
            'action',
            'role',
            'allow',
            //'user_creator',
            //'date_m',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ControllerRules $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
