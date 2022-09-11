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
    <div class="container-menu bg-warning">
        <div class="container">
            <?= $this->render("@app/views/header/searchLine") ?>
            <?= $this->render("@app/views/header/topMenu") ?>
            <?= $this->render("@app/views/header/sideMenu") ?>
        </div>
    </div>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container-grey container-100">
        <div class="container container-grey py-4 ">
            <div class="row text-center ">
                <a class="col-lg-4 menu-text-size-title p-0 " href="#">
                    <div class="bg-warning products-button-r products-button">
                        <div>Товары по акции</div>
                    </div>
                </a>
                <a class="col-lg-4 menu-text-size-title p-0 " href="#">
                    <div class="bg-warning products-button-c products-button">
                        <div>Новинки</div>
                    </div>
                </a>
                <a class="col-lg-4 menu-text-size-title p-0 " href="#">
                    <div class="bg-warning products-button-l products-button">
                        <div>Рекомендуем</div>
                    </div>
                </a>
            </div>
            <div class="py-4">
                <?= ProductsList::widget() ?>
            </div>
            <div class="row text-center align-self-center">
                <a class="col-lg-4 mx-auto menu-text-size-title p-0 " href="#">
                    <div class="bg-warning products-button-c products-button">
                        <div>Перейти на страницу</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="container-100 bg-warning">
        <div class="container bg-warning py-4">
            <h2>Наши приемущества</h2>
            qqqqq
        </div>
    </div>
    <div class="container-grey container-100">
        <div class="container container-grey py-4">
            <h2 class="text-center">Бренды которые мы предлагаем</h2>
            <div class="py-4"><?= BrandList::widget() ?></div>
            <div class="row text-center align-self-center">
                <a class="col-lg-4 mx-auto menu-text-size-title p-0 " href="#">
                    <div class="bg-warning products-button-c products-button">
                        <div>Все бренды</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <?= NewsList::widget() ?>
        <div class="row text-center align-self-center">
            <a class="col-lg-4 mx-auto menu-text-size-title p-0 " href="#">
                <div class="bg-warning products-button-c products-button">
                    <div>На страницу новостей</div>
                </div>
            </a>
        </div>
    </div>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>
<footer>
    <?= $this->render("@app/views/footer/footer.php") ?>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
