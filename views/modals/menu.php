<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\Tabs;

Modal::begin([
    'id' => 'modalMenu',
    'header' => "<h4>Меню</h4>",
    'size' => Modal::SIZE_LARGE,
    'clientOptions' => [
        'show' => false,
    ],
]);

if (Yii::$app->user->can('editor')) {
    echo '<h4>' . Html::a('Панель управления', Url::to(['admin/index']), ['class' => 'text-danger']) . '</h4><hr />';
} else if (Yii::$app->user->can('user')) {
    echo '<h4>' . Html::a('Личный кабинет', Url::to(['kabinet/index']), ['class' => 'text-success']) . '</h4><hr />';
}

echo Tabs::widget([
    'items' => $array,
]);

Modal::end();
