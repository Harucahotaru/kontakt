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
                'deleteUrl' => Url::toRoute(["products/delete-img", 'productId' => $model->id,]),
                'showUpload' => false,
                'showRemove' => false,
                'initialPreview' => $model->getImagesPath(),
                'initialPreviewAsData' => true,
            ]
        ]
    ); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true,]
            ) ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'article')->textInput(['maxlength' => true,]
            ) ?>
        </div>

        <div class="col-lg-2">
            <?= $form->field($model, 'active')->dropDownList(Products::getStatusList(), []) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'currency')->textInput(['maxlength' => true,]) ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($model, 'sale')->textInput(['maxlength' => true,]) ?>
        </div>

        <div class="col-lg-2">
            <?= $form->field($model, 'on_sale')->dropDownList(Products::getSaleStatusList(), []) ?>
        </div>
    </div>

    <?= $form->field($model, 'category_id')->dropDownList(ProductsCategories::getAllCategoriesList(), [
            'style' => 'width: 30%',
        ]
    ) ?>

    <?= $form->field($model, 'brand_id')->dropDownList(Brands::getBrandNamesList(), [
            'prompt' => 'Выбрать производителя...',
            'style' => 'width: 30%',
        ]
    ) ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::class, [
            'data' => $model->getParentProductsList(),
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]
    ) ?>

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
