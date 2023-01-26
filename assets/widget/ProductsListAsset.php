<?php

namespace app\assets\widget;

use yii\web\AssetBundle;

class ProductsListAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets';
    public $css = [
        'css/products-list.css',
    ];
}