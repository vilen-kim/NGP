<?php

namespace app\assets;

use yii\web\AssetBundle;

class SiteAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/animations.css',
    ];
    public $js = [
        'js/news.js',
        'js/css3-animate-it.js',
        'js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
