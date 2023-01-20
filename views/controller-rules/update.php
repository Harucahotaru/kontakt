<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ControllerRules */

$this->title = 'Изменить правило: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Управление доступом', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="controller-rules-update container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
