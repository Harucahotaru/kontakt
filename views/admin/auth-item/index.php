<?php

use app\models\AuthItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AuthItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Роли';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => '/user'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index container">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать роль', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'type',
            'description:ntext',
            'rule_name',
            'data',
            'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {edit-rules}',
                'urlCreator' => function ($action, AuthItem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'name' => $model->name]);
                 },
                 'buttons' => [
                    'edit-rules' => function ($url) {
                        return (Yii::$app->user->can('admin')) ? Html::a('<i class="fas fa-user-plus"></i>', $url, ['title' => 'Редактирование прав']) : '';
                    }
                ]
            ],
        ],
    ]); ?>


</div>
