<?php

namespace app\assets;

use yii\web\AssetBundle;

class EyeAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/eye.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
