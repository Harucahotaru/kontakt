<?php
/**
 * @var $model UserController
 */

use app\controllers\UserController;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row py-5">
    <div class="site-signup  col-md-4 mx-auto center-block">
        <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->widget(PasswordInput::class, ['language' => 'ru']); ?>

            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success col-lg-12', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
