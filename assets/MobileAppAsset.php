<?php

namespace app\assets;

use yii\web\AssetBundle;

class MobileAppAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/layout/mobile/all.css',
        'css/layout/mobile/footer.css',
        'css/layout/mobile/hover.css',
        'css/layout/ny2018.css',
    ];
    public $js = [
        'js/yandex.js',
        'js/ny2018.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
