<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="site-login col-md-8 mx-auto center-block">
        <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
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

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div>
            <?= Html::a('Create account', ['/user/signup']) ?>.
        </div>

        <div>
            <?= Html::a('Forgot password ?', ['/user/request-password-reset']) ?>.
        </div>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\" col-lg-8 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary col-lg-12', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
