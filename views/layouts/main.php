<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\models\Brands;
use app\widgets\Alert;
use app\widgets\BrandList;
use app\widgets\NewsList;
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
    <div class="container-blue-100">
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
    <div class="container">
        <?= NewsList::widget(['title' => 'Последние новости']); ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
