<?php

/** @var User $user */

use app\models\AuthAssignment;
use app\models\User;
use kartik\sortinput\SortableInput;
use yii\helpers\Html;
use yii\widgets\DetailView;

$userRules = AuthAssignment::getUserRulesToKartik($user->id);
$this->title = 'Редактирование прав';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = "$this->title - $user->username";
?>
<div class="container">

    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <?= Html::beginForm('/user/save-rules', 'post', ['class' => 'form-inline']); ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="py-2">Доступные права</div>
            <?= SortableInput::widget([
                'name' => 'parent',
                'items' => array_diff_key(AuthAssignment::getRulesListToKartik(), $userRules),
                'hideInput' => true,
                'sortableOptions' => [
                    'connected' => true,
                ],
                'options' => ['class' => 'form-control', 'readonly' => true]
            ]); ?>
        </div>
        <div class="col-lg-6">
            <div class="py-2">Права пользователя - <?= $user->username ?></div>
            <?= SortableInput::widget([
                'name' => 'rules',
                'items' => array_merge(
                    ['default' => ['content' => 'Базовый набор прав', 'disabled' => true]],
                    $userRules,
                ),
                'hideInput' => true,
                'sortableOptions' => [
                    'connected' => true,
                ],
                'options' => ['class' => 'form-control', 'readonly' => false]
            ]); ?>
        </div>

        <?= Html::hiddenInput('user_id', $user->id) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-4']) ?>
    </div>

    <?= Html::endForm(); ?>

</div>