<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Вход в аккаунт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row py-5">
    <div class="site-login col-md-4 mx-auto center-block">
        <div>
            <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => "example@mail.ru"])->label('Имя пользователя') ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => "********"])->label('Пароль') ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'id' => 'feed-status',
                'class' => 'form-check-input',
                'value' => 0,
            ])->label('Запомнить меня', [
                'class' => 'form-check-label',
                'for' => 'feed-status',
            ]) ?>

            <div class="form-group py-2">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-success col-lg-12', 'name' => 'login-button']) ?>
            </div>

            <div class="py-1">
                <?= Html::a('Создать аккаунт', ['/user/signup']) ?>.
            </div>

<!--            <div class="py-1">-->
<!--                --><?php //Html::a('Востановить пароль', ['/user/request-password-reset']) ?><!--.-->
<!--            </div>-->

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
