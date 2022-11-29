<?php

use kartik\editors\Summernote;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?php foreach ($model->pagesContent as $key => $content): ?>

        <?=
            Summernote::widget([
                'name' => "Pages[pagesContent][{$content->id}]content",
                'value' => $content->content,
            ]);
        ?>

    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
