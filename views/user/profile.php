<?php

use app\models\User;

/** @var User $user */

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="py-2">
        <a href="/user/logout" class="btn btn-danger" role="button">Выйти из профиля</a>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="py-3">
                <div class="<?= !file_exists('') ? 'no-image' : ''?> profile-image-box">
                    <img <?= file_exists('') ? 'src="/"' : ''?>>
                </div>
            </div>
            <h4>Данные пользователя</h4>
            <ul class="profile-information">
                <li><b>Username:</b> <?= $user->username ?></li>
                <li><b>Email:</b> <?= $user->email ?></li>
            </ul>
        </div>
<!--        <div class="col-lg-6">-->
<!--            <h4>Любимые товары: </h4>-->
<!--        </div>-->
    </div>
    <div class="line"></div>
<!--    <div class="py-5">-->
<!--        <h3>История заказов: </h3>-->
<!--    </div>-->
</div>