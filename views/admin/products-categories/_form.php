<?php

use app\models\ProductsCategories;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ProductsCategories $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="products-categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_main_category')->dropDownList(ProductsCategories::getStatusList()) ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::className(), [
        'data' => ProductsCategories::getAllCategoriesList(),
        'size' => Select2::MEDIUM,
        'options' => [
            'placeholder' => 'Выбрать категорию выше по древу ...',
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <div class="form-group py-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
