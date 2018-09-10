<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/layout/all.css',
        'css/layout/header.css',
        'css/layout/footer.css',
        'css/layout/hover.css',
    ];
    public $js = [
        'js/header.js',
        'js/yandex.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
