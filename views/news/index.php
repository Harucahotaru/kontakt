<?php

use app\widgets\NewsList;
use yii\bootstrap5\Html;

?>
<div class="container">
    <?= NewsList::widget() ?>
    <div class="row text-center align-self-center py-4">
        <a class="col-lg-4 mx-auto menu-text-size-title p-0 " href="/news">
            <div class="bg-warning products-button-c products-button">
                <div>На страницу новостей</div>
            </div>
        </a>
    </div>
</div>