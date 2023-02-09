<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AuthItem $model */

$this->title = 'Создать роль';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => '/user'];
$this->params['breadcrumbs'][] = ['label' => 'роли', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
