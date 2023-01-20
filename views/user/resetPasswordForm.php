<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $resetPasswordModel \app\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Востановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <div class="row py-5">
        <div class="col-lg-5 mx-auto center-block">

            <h1><?= Html::encode($this->title) ?></h1>

            <p>Пожалуйста, введите новый пароль:</p>

            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($resetPasswordModel, 'password')->passwordInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success col-lg-12']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>