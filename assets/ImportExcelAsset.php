<?php

namespace app\assets;

use yii\web\AssetBundle;

class ImportExcelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/importExcel.js',
    ];
}