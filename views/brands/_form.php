<?php

use kartik\editors\Summernote;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Brands */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brands-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'imgFile')->widget(FileInput::classname(), [
        'options' =>
            [
                'accept' => 'image/*'
            ],
        'language' => 'ru',
        'pluginOptions' =>
            [
                'maxFileCount' => 10,
                'deleteUrl' => Url::toRoute(["brands/delete-img", 'brandId' => $model->id]),
                'showUpload' => false,
                'showRemove' => false,
                'initialPreview' => $model->imgPath,
                'initialPreviewAsData' => true,
            ]
    ]); ?>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'urlname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <?= $form->field($model, 'description')->widget(Summernote::class, [
            'useKrajeePresets' => true,
            'language' => 'ru',
            'pluginOptions' => [
                'allowClear' => true,
                'toolbarOptions' => false,
            ],
        ]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
