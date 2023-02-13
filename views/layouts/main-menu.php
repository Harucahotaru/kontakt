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
    <div class="mb-0 text-center p-0">
        <?php Yii::$app->session->addFlash('error', 'Сайт находится в разработке. Скоро мы предоставим Вам информацию в лучшем виде!');?>
        <?= Alert::widget([
            'options' => [
                'class' => 'main-alert m-0',
            ],
        ]); ?>
    </div>
    <div class="container-menu bg-warning">
        <div class="container">
            <?= $this->render("@app/views/header/searchLine") ?>
            <?= $this->render("@app/views/header/topMenu") ?>
            <?= $this->render("@app/views/header/sideMenu") ?>
        </div>
    </div>
</header>
<?= $this->render("@app/views/admin/templates/admin-panel") ?>
<main role="main" class="flex-shrink-0">
    <div>
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