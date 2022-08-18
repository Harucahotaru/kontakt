<?php

namespace app\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = '@bower/font-awesome';

    /**
     * @inherit
     */
    public $css = [
        'css/all.css',
    ];
}