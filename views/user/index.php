<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index container">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= (Yii::$app->user->can('admin')) ? Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success mr-2']) : ''; ?>
        <?= (Yii::$app->user->can('admin')) ? Html::a('Роли', '/admin/auth-item', ['class' => 'btn btn-secondary mx-2']) : ''; ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
            'username',
            'email:email',
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:d.m.y H:i']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['datetime', 'php:d.m.y H:i']
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {edit-rules}',
                'urlCreator' => function ($action, User $model) {
                    return Url::toRoute([$action, 'id' => $model->id]);
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
