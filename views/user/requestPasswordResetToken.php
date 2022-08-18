<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */

/* @var $passwordResetModel \app\models\PasswordResetRequestForm */

use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;


$this->title = 'Password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="site-request-password-reset col-md-8 mx-auto center-block">
        <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form',
            'layout' => 'horizontal',
            'options' => [
                'class' => 'col-lg-5 ms-auto me-auto',
                'enctype' => 'multipart/form-data'
            ],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
            ],
        ]); ?>

        <?= $form->field($passwordResetModel, 'email')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>