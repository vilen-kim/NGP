<?php

namespace app\assets;

use yii\web\AssetBundle;

class SiteAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/animations.css',
    ];
    public $js = [
        'js/css3-animate-it.js',
        'js/parallax.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
