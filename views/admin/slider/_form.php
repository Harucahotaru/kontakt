<?php

use app\models\Slider;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Slider */
/* @var $form yii\widgets\ActiveForm */
$model->status = $model->isNewRecord ? 1 : $model->status;
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'imgFile')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'deleteUrl' => Url::toRoute(["slider/delete-img", 'slideId' => $model->id]),
            'showUpload' => false,
            'showRemove' => false,
            'initialPreview' => [
                $model->imgPath
            ],
            'initialPreviewAsData' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'type')->dropDownList(Slider::getTypeList()) ?>

    <?= $form->field($model, 'status')->dropDownList(Slider::getStatusList()) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'content_options[slider][css][position]')->label('Растяжение картинки')->dropDownList(Slider::getPositionList()) ?>

    <div class="form-group mt-2">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
