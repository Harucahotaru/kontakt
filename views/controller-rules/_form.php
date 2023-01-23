<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ControllerRules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="controller-rules-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'controller_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'allow')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success my-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
