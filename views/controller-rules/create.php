<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ControllerRules */

$this->title = 'Создать правило';
$this->params['breadcrumbs'][] = ['label' => 'Управление доступом', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="controller-rules-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
