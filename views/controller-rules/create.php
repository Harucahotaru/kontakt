<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ControllerRules */

$this->title = 'Create Controller Rules';
$this->params['breadcrumbs'][] = ['label' => 'Controller Rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="controller-rules-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
