<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */

/* @var $passwordResetModel \app\models\PasswordResetRequestForm */

use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;


$this->title = 'Востановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row py-5">
    <div class="site-request-password-reset col-md-4 mx-auto center-block">
        <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin()?>

        <?= $form->field($passwordResetModel, 'email')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-success col-lg-12']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>