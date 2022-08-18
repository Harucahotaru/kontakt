<?php
\app\assets\NewsAsset::register($this);

use yii\bootstrap5\Html;

?>
<div class="news-list">
    <div class="row mb-4">
        <div class="col-lg-4">
            <div class="news-cart-block">
                <a href="#">
                    <div class="news-cart-container" style="background: top/cover url('/upload/images/news/simple.jpg')">
                        <div class="news-cart-text text-top" style="background: linear-gradient(to top, rgba(0,255,255,0), cyan);">
                        <div class="news-cart-title text-uppercase"><h2>Title news</h2></div>
                        <div class="news-cart-caption fs-5">Caption news</div>
                        </div>
                    </div>
                </a>
                <div class="edit-news">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <?= Html::a('<i class="fa-regular fa-trash-can"></i>', ['user/adress-delete'],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить адрес?',
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="news-cart-block">
                <a href="#">
                    <div class="news-cart-container" style="background: top/cover url('/upload/images/news/simple.jpg')">
                        <div class="news-cart-text text-bot" style="background: linear-gradient(to top, red,rgba(0,255,255,0));">
                            <div class="news-cart-title text-uppercase"><h2>Title news</h2></div>
                            <div class="news-cart-caption fs-5">Caption news</div>
                        </div>
                    </div>
                </a>
                <div class="edit-news">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <?= Html::a('<i class="fa-regular fa-trash-can"></i>', ['user/adress-delete'],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить адрес?',
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="news-cart-block">
                <a href="#">
                    <div class="news-cart-container" style="background: top/cover url('/upload/images/news/simple.jpg')">
                        <div class="news-cart-text text-bot" style="background: linear-gradient(to top, red,rgba(0,255,255,0));">
                            <div class="news-cart-title text-uppercase"><h2>Title news</h2></div>
                            <div class="news-cart-caption fs-5">Caption news</div>
                        </div>
                    </div>
                </a>
                <div class="edit-news">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <?= Html::a('<i class="fa-regular fa-trash-can"></i>', ['user/adress-delete'],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить адрес?',
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="news-cart-block">
                <a href="#">
                    <div class="news-cart-container" style="background: top/cover url('/upload/images/news/simple.jpg')">
                        <div class="news-cart-text text-top" style="background: linear-gradient(to top, rgba(0,255,255,0), cyan);">
                            <div class="news-cart-title text-uppercase"><h2>Title news</h2></div>
                            <div class="news-cart-caption fs-5">Caption news</div>
                        </div>
                    </div>
                </a>
                <div class="edit-news">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <?= Html::a('<i class="fa-regular fa-trash-can"></i>', ['user/adress-delete'],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить адрес?',
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="news-cart-block">
                <a href="#">
                    <div class="news-cart-container" style="background: top/cover url('/upload/images/news/simple.jpg')">
                        <div class="news-cart-text text-bot" style="background: linear-gradient(to top, red,rgba(0,255,255,0));">
                            <div class="news-cart-title text-uppercase"><h2>Title news</h2></div>
                            <div class="news-cart-caption fs-5">Caption news</div>
                        </div>
                    </div>
                </a>
                <div class="edit-news">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <?= Html::a('<i class="fa-regular fa-trash-can"></i>', ['user/adress-delete'],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить адрес?',
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="news-cart-block">
                <a href="#">
                    <div class="news-cart-container" style="background: top/cover url('/upload/images/news/simple.jpg')">
                        <div class="news-cart-text text-bot" style="background: linear-gradient(to top, red,rgba(0,255,255,0));">
                            <div class="news-cart-title text-uppercase"><h2>Title news</h2></div>
                            <div class="news-cart-caption fs-5">Caption news</div>
                        </div>
                    </div>
                </a>
                <div class="edit-news">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <?= Html::a('<i class="fa-regular fa-trash-can"></i>', ['user/adress-delete'],
                        [
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить адрес?',
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>