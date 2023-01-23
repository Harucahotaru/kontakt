<?php

use app\models\User;
use app\widgets\ProductCart;

/** @var User $user */
/** @var $cartPrice */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-grey">
    <div class="container">
        <h1 class="py-4">Товары в корзине: </h1>
        <div class="card-all-cost">Общая стоимость: <?= $cartPrice?></div>
        <?= ProductCart::widget(['userId' => $user->id]) ?>
    </div>
</div>

