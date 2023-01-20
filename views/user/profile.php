<?php

$user = Yii::$app->user;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="py-2">
        <a href="/user/logout" class="btn btn-danger" role="button">Выйти из профиля</a>
    </div>
    <div>
        Корзина
    </div>
    <div>
        Любимые товары
    </div>
</div>