<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\models\Brands;
use app\widgets\Alert;
use app\widgets\BrandList;
use app\widgets\BrandsList;
use app\widgets\NewsList;
use app\widgets\ProductsList;
use app\widgets\Slides;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<header>
    <div class="container-100 container-blue">
        Сообщение что что-то временно не работает
    </div>
    <div class="container-menu-small bg-warning">
        <div class="container">
            <?= $this->render("@app/views/header/searchLine") ?>
        </div>
    </div>
</header>
<div class="container-grey">
    <div class="side-menu">
        <div class="flex-shrink-0 p-1 bg-warning" style="width: 280px;">
            <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <div class="menu-tex">
                        <button class="side-menu-button btn-toggle align-items-center " data-bs-toggle="collapse"
                                data-bs-target="#first" aria-expanded="true">
                            <a class="menu-text-size-title">Кабели и растяжки</a>
                        </button>
                    </div>
                    <div class="collapse show px-3" id="first" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                            <li><a href="#" class="link-dark rounded">Кабели</a></li>
                            <li><a href="#" class="link-dark rounded">Разтяжки</a></li>
                            <li><a href="#" class="link-dark rounded">Разтяжки</a></li>
                            <li><a href="#" class="link-dark rounded">Разтяжки</a></li>
                            <li><a href="#" class="link-dark rounded">Разтяжки</a></li>
                            <li><a href="#" class="link-dark rounded">Разтяжки</a></li>
                            <li><a href="#" class="link-dark rounded">Разтяжки</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="flex-shrink-0 p-1 bg-warning " style="width: 280px;">
            <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <div class="menu-tex">
                        <button class="side-menu-button btn-toggle align-items-center " data-bs-toggle="collapse"
                                data-bs-target="#second" aria-expanded="true">
                            <a class="menu-text-size-title">Бытовые приборы</a>
                        </button>
                    </div>
                    <div class="collapse px-3" id="second" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                            <li><a href="#" class="link-dark rounded">Инструменты</a></li>
                            <li><a href="#" class="link-dark rounded">Расходные материалы</a></li>
                            <li><a href="#" class="link-dark rounded">Расходные материалы</a></li>
                            <li><a href="#" class="link-dark rounded">Расходные материалы</a></li>
                            <li><a href="#" class="link-dark rounded">Расходные материалы</a></li>
                            <li><a href="#" class="link-dark rounded">Расходные материалы</a></li>
                            <li><a href="#" class="link-dark rounded">Расходные материалы</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="catalog-container">
        <div class="container pt-3">
            <div class="row">
                <div class="col-lg-2 align-self-center">
                    <select class="catalog-form-select">
                        <option selected>Сортировать:</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-lg-2 align-self-center">
                    <div class="row">
                        <div class="col-lg-8">
                            Есть в наличии
                        </div>
                        <div class="form-chec col-lg-2 align-self-center">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            </label>
                        </div>
                    </div>
                </div>

            </div>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= ProductsList::widget() ?>
        </div>

    </div>
</div>
</main>
<footer>
    <?= $this->render("@app/views/footer/footer.php") ?>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
