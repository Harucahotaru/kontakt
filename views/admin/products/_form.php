<?php

use kartik\editors\Summernote;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'imgFile[]')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
            'multiple' => true,
        ],
        'language' => 'ru',
        'pluginOptions' => [
            'maxFileCount' => 10,
            'deleteUrl' => Url::toRoute(["slider/delete-img", 'slideId' => $model->id]),
            'showUpload' => false,
            'showRemove' => false,
            'initialPreview' => $model->getImagesPath(),
            'initialPreviewAsData' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'description')->widget(Summernote::class, [
        'useKrajeePresets' => true,
    ]);
    ?>

    <?= $form->field($model, 'article')->textInput() ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'on_sale')->dropDownList(\app\models\Products::getSaleStatusList()) ?>

    <?= $form->field($model, 'sale')->textInput() ?>

    <?= $form->field($model, 'category_id')->textInput(['maxlength' => true, 'value' => 1]) ?>

    <?= $form->field($model, 'parent_id')->textInput(['maxlength' => true, 'value' => 1]) ?>

    <?= $form->field($model, 'active')->dropDownList(\app\models\Products::getStatusList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
