<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <?= $content['main']->content?>
        </div>
        <div class="col-lg-6">
            <div><img style="width: 100%" src="/upload/images/about/1.jpg"></div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12 contacts-map">
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A79e6e8a0c31ed764a2933255e031d39f2bc1f9b757465dcf7e7e5b42b098ae8c&amp;width=1200&amp;height=600&amp;lang=ru_RU&amp;scroll=false"></script>
        </div>
    </div>
</div>
