<?php

use app\models\Brands;
use app\models\Products;
use app\models\ProductsCategories;
use kartik\editors\Summernote;
use kartik\file\FileInput;
use kartik\select2\Select2;
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

    <?= $form->field($model, 'article')->textInput() ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'on_sale')->dropDownList(Products::getSaleStatusList()) ?>

    <?= $form->field($model, 'sale')->textInput() ?>

    <?= $form->field($model, 'category_id')->dropDownList(ProductsCategories::getAllCategoriesList()) ?>

    <?= $form->field($model, 'brand_id')->dropDownList(Brands::getBrandNamesList(), ['prompt'=>'Выбрать производителя...']) ?>

    <?= $form->field($model, 'parent_id[]')->widget(Select2::className(), [
        'data' => $model->getParentProductsList(),
        'size' => Select2::MEDIUM,
        'options' => [
            'placeholder' => 'Выбрать подходящие товары ...',
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'active')->dropDownList(Products::getStatusList()) ?>

    <?=
    $form->field($model, 'description')->widget(Summernote::class, [
        'useKrajeePresets' => true,
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
