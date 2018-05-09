<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

Modal::begin([
    'id' => 'modalMenu',
    'header' => "<h4>Меню</h4>",
    'size' => Modal::SIZE_DEFAULT,
    'clientOptions' => [
        'show' => false,
    ],
]);

if (Yii::$app->user->can('editor')) {
    echo '<h4>' . Html::a('Панель управления', Url::to(['admin/index']), ['class' => 'text-danger']) . '</h4><hr />';
} else if (Yii::$app->user->can('user')) {
    echo '<h4>' . Html::a('Личный кабинет', Url::to(['kabinet/index']), ['class' => 'text-success']) . '</h4><hr />';
}
    
$begin = false;
if (isset($array)){
    foreach($array as $arr){
        if ($arr['type'] == 'menu'){
            if ($begin){
                echo '</ul>';
            }
            echo '<h4>' . $arr['link'] . '</h4>';
            $begin = false;
        } else {
            if (!$begin){
                echo '<ul>';
                $begin = true;
            }
            echo '<li>' . $arr['link'] . '</li>';
        }
    }
}

Modal::end();