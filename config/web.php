<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'language' => 'ru-RU',
    'layout' => 'main',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@resourses' => '@app/resourses',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'uCW0y0nsdsYTNwOa10Uqx-Z8PaZN2GEJ',
        ],
        'assetManager' => [
            'linkAssets' => true,
            'forceCopy' => true,
            //disable caching assets
            'appendTimestamp' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                'about' => 'site/about',
                'contacts' => 'site/contact',
                'images' => 'images/index',
                'catalog/add-to-cart' => 'catalog/add-to-cart',
                'catalog/add-to-cart-by-view' => 'catalog/add-to-cart-by-view',
                'news/category-<category>' => 'news/categories',
                'news/<category>/<urlnews>' => 'news/detail-news',
                'news' => 'news/categories',
                'admin' => 'admin/main/index',
                'reviews/delete/<reviewId>' => 'admin/reviews/delete',
                'reviews/accept/<reviewId>' => 'admin/reviews/accept',
                'reviews' => 'admin/reviews/index',
                'reviews/<reviewType>' => 'admin/reviews',
                'catalog/search/<searchString>' => 'catalog/search',
                'catalog/brand/<brandId>' => 'catalog/brand',
                'brands/search/<searchString>' => 'brands/search',
                'catalog/view/<productId>' => 'catalog/view',
                [
                    'pattern' => 'catalog/<mainCategory>/<subCategory>/<subCategory2>',
                    'route' => 'catalog',
                    'defaults' => ['mainCategory' => null, 'subCategory' => null, 'subCategory2' => null],
                ],
                '<path:\w+>/<controller:\w+>/<action:\w+>' => '<path>/<controller>/<action>',
            ],
            'showScriptName' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:j M Y',
            'datetimeFormat' => 'php:Y.M.j H:i:s',
            'timeFormat' => 'php:H:i',
            'timeZone' => 'Europe/Moscow',
            'defaultTimeZone' => 'Europe/Moscow',
        ],
        'db' => $db,
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
