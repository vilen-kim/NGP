<?php

namespace app\assets;

use yii\web\AssetBundle;

class RequestAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/request.css',
    ];
    public $js = [
        'js/request.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
