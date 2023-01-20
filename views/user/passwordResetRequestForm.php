<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \app\models\PasswordResetRequestForm $passwordResetModel
 */
$this->title = 'Востановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row py-5">
    <div class="site-request-password-reset col-md-4 mx-auto center-block">
        <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin([]); ?>
        <?= $form->field($passwordResetModel, 'email')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>