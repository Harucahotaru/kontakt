<?php
/**
 * @var $model \app\controllers\UserController
 */

use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="site-signup  col-md-8 mx-auto center-block">
        <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div
            ">

            <?php $form = ActiveForm::begin(['id' => 'form-signup',
                'layout' => 'horizontal',
                'options' => [
                    'class' => 'col-lg-5 ms-auto me-auto',
                    'enctype' => 'multipart/form-data'
                ],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                ],
            ]); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->widget(PasswordInput::class, []); ?>
            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary col-lg-12', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
