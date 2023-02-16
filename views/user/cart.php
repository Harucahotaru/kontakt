<?php

use app\models\User;
use app\widgets\ProductCart;
use yii\widgets\Pjax;

/** @var User $user */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => "pjax_cart_plus_$user->id", 'enablePushState' => false]) ?>
<div class="container-grey">
    <div class="container py-4">
        <h1 class="py-4">Товары в корзине: </h1>
        <?= ProductCart::widget(['userId' => $user->id]) ?>
    </div>
</div>
<?php Pjax::begin() ?>

