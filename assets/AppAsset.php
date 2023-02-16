<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\bootstrap5\BootstrapPluginAsset;
use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/navbar.css',
        'css/menu.css',
        'css/catalog.css',
        'css/swiper.css',
        'css/adminReview.css',
        'css/userProfile.css',
        'css/admin-products.css',
        'css/cart.css',
    ];
    public $js = [
        'js/site.js',
        'js/searchLine.js',
        'js/massActions.js',
        'js/productsSort.js',
        'js/cart.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        BootstrapPluginAsset::class,
        FontAwesomeAsset::class
    ];
}
