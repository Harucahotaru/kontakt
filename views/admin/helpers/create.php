<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Helpers $model */

$this->title = 'Создать подсказку';
$this->params['breadcrumbs'][] = ['label' => 'Подсказки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="helpers-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
