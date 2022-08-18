<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $allRoles array */
?>


<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model, 'username')->textInput(['placeholder' => 'Title', 'disabled' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Title', 'disabled' => true]) ?>
    <?= $form->field($model, 'roles')->dropDownList(
        $allRoles, ['multiple' => 'multiple']
    ); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
