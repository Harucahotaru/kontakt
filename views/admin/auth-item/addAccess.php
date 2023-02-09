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