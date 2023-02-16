<?php

use app\models\User;
use app\widgets\ProductCart;

/** @var User $user */
/** @var $cartPrice */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-grey">
    <div class="container py-4">
        <h1 class="py-4">Товары в корзине: </h1>
        <?php if (!empty($cartPrice)): ?>
        <div class="card-all-cost">Общая стоимость: <?= $cartPrice?></div>
        <?php endif; ?>
        <?= ProductCart::widget(['userId' => $user->id]) ?>
    </div>
</div>

