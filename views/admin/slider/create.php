<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Slider */

$this->title = 'Create Slider';
$this->params['breadcrumbs'][] = ['label' => 'Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container slider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
