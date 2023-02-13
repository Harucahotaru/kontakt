<?php

use app\models\Helpers;
use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Helpers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="helpers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(Summernote::class, [
        'useKrajeePresets' => true,
    ]); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'placeholder' => '/site/news'])?>

    <?= $form->field($model, 'type')->dropDownList(Helpers::getHelpersTypeList())?>

    <?= $form->field($model, 'item')->hiddenInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
