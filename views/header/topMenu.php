<?php

use app\classes\Nav;
use yii\bootstrap5\NavBar;

NavBar::begin([
    'options' => [
        'class' => 'navbar navbar-expand-lg navbar-dark bg-dark fixed-top menu',
    ],
    'innerContainerOptions' => ['class' => 'container position-relative']
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        ['label' => '<i class="fa-solid fa-house-chimney"></i> Home', 'url' => Yii::$app->homeUrl, 'encode' => false, 'options' => ['class' => '']],
        ['label' => 'Contact', 'url' => ['/site/contact'], 'encode' => false, 'options' => ['class' => '']],
        [
            'label' => 'News',
            'encode' => false,
            'options' => ['class' => ''],
            'items' => [
                [
                    ['label' => 'Заголовок 1'],
                    ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                    ['label' => 'Level 1 - Dropdown B', 'url' => '#']
                ],
                [
                    ['label' => 'Заголовок 1'],
                    ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                    ['label' => 'Level 1 - Dropdown B', 'url' => '#']
                ], [
                    ['label' => 'Заголовок 1'],
                    ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                    ['label' => 'Level 1 - Dropdown B', 'url' => '#']
                ], [
                    ['label' => 'Заголовок 1'],
                    ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                    ['label' => 'Level 1 - Dropdown B', 'url' => '#']
                ],
                [
                    'label' => 'Все заголовки',
                    'tag' => 'a',
                    'options' => [
                        'href' => 'as',
                        'class' => 'btn btn-outline-secondary w-100 mt-2']
                ]
            ],
        ],
        [
            'label' => '<i class="fa-solid fa-gears"></i> Admin',
            'encode' => false,
            'options' => ['class' => 'red-600   '],
            'visible' => Yii::$app->user->can('moderator'),
            'items' => [
                [
                    ['label' => 'Site panel'],
                    ['label' => 'Slider', 'url' => ['/slider']],
                    ['label' => 'News', 'url' => ['/news']],
                    ['label' => 'Images', 'url' => ['/images']],
                ],
                [
                    ['label' => 'Users panel'],
                    ['label' => 'Users', 'url' => ['/user']],
                    ['label' => 'Roles', 'url' => ['/controller-rules']],
                ],
                [
                    'label' => 'Admin page',
                    'tag' => 'a',
                    'options' => [
                        'href' => '/admin',
                        'class' => 'btn btn-outline-secondary w-100 mt-2']
                ]
            ],
        ],
        ['label' => 'Games', 'url' => ['/games']],
        [
            'label' => 'User',
            'encode' => false,
            'options' => ['class' => 'position-absolute end-0'],
            'items' => [
                ['label' => 'Site panel'],
                ['label' => 'Profile', 'url' => ['#']],
                ['label' => 'Login', 'url' => ['/user/login'], 'visible' => Yii::$app->user->isGuest,],
                ['label' => 'Logout', 'url' => ['/user/logout'], 'visible' => !Yii::$app->user->isGuest],
            ],
        ],

    ],
]);
NavBar::end();
?>
