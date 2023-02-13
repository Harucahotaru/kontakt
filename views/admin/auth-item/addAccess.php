<?php

/** @var AuthItem $authItem */

use app\models\AuthItem;
use kartik\sortinput\SortableInput;
use yii\helpers\Html;
use yii\widgets\DetailView;

$authItemTiles = $authItem->getAuthItemAdminTilesKartikList();

$this->title = 'Изменение прав роли';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['/admin/auth-item']];
$this->params['breadcrumbs'][] = "$this->title - $authItem->name";
$authItem->rules = json_decode($authItem->rules, true);
?>
<div class="container">
    <?= DetailView::widget([
        'model' => $authItem,
        'attributes' => [
            'name',
            'type',
            'description:ntext',
        ],
    ]) ?>

    <?= Html::beginForm('/admin/auth-item/save-tiles', 'post', ['class' => 'form-inline']); ?>

    <h2 class="pt-4">Права для интерфейса</h2>
    <div>
        <div class="row py-2">
            <div class="col-lg-3">
                <?= Html::label('Может ли пользователь с этой ролью видеть цену товара') ?>
            </div>
            <div class="col-lg-1">
                <?= Html::checkbox('can_view_cost',
                    isset($authItem->rules['can_view_cost']) ? $authItem->rules['can_view_cost'] : false,
                    [] ) ?>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-lg-3">
                <?= Html::label('Доступна ли пользователям корзина') ?>
            </div>
            <div class="col-lg-1">
                <?= Html::checkbox('can_use_cart',
                    isset($authItem->rules['can_use_cart']) ? $authItem->rules['can_use_cart'] : false,
                    [] ) ?>
            </div>
        </div>
    </div>
    <h2 class="pt-4">Доступ к панели администратора</h2>
    <div class="row">
        <div class="col-lg-6">
            <div class="py-2">Все инструменты на панели администратора</div>
            <?= SortableInput::widget([
                'name' => 'parent',
                'items' => array_diff_key(AuthItem::getAdminTilesKartikList(), $authItemTiles),
                'hideInput' => true,
                'sortableOptions' => [
                    'connected' => true,
                ],
                'options' => ['class' => 'form-control', 'readonly' => true]
            ]); ?>
        </div>
        <div class="col-lg-6">
            <div class="py-2">Доступные инструменты для роли - <?= $authItem->name ?></div>
            <?= SortableInput::widget([
                'name' => 'rules',
                'items' => $authItemTiles,
                'hideInput' => true,
                'sortableOptions' => [
                    'connected' => true,
                ],
                'options' => ['class' => 'form-control', 'readonly' => false]
            ]); ?>
        </div>

        <?= Html::hiddenInput('auth_item_name', $authItem->name) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-4']) ?>
    </div>

    <?= Html::endForm(); ?>

</div>