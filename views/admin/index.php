<?php

use yii\helpers\Html;
use yii\helpers\Url;

app\assets\AdminAsset::register($this);
$this->title = 'Панель управления';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="admin-index row">

    <?php
    $array = [
        'user' => [
            'count' => '<span class="badge">' . $count['users'] . '</span>',
            'url' => Yii::$app->user->can('admin') ? Url::to(['auth/index']) : '',
            'caption' => 'Пользователи',
            'options' => Yii::$app->user->can('admin') ? ['class' => 'btn btn-default changeBack'] : ['class' => 'btn btn-default', 'disabled' => '', 'onClick' => 'return false;'],
        ],
        'menu' => [
            'count' => '<span class="badge">' . $count['menu'] . '</span>',
            'url' => Yii::$app->user->can('manager') ? Url::to(['menu/index']) : '',
            'caption' => 'Меню',
            'options' => Yii::$app->user->can('manager') ? ['class' => 'btn btn-default changeBack'] : ['class' => 'btn btn-default', 'disabled' => '', 'onClick' => 'return false;'],
        ],
        'pages' => [
            'count' => '<span class="badge">' . $count['pages'] . '</span>',
            'url' => Yii::$app->user->can('editor') ? Url::to(['pages/index']) : '',
            'caption' => 'Страницы',
            'options' => Yii::$app->user->can('editor') ? ['class' => 'btn btn-default changeBack'] : ['class' => 'btn btn-default', 'disabled' => '', 'onClick' => 'return false;'],
        ],
    ];

    foreach ($array as $arr) {
        echo '<div class="col-md-4">';
        echo Html::a($arr['caption'] . ' ' . $arr['count'], $arr['url'], $arr['options']);
        echo '</div>';
    }
    ?>
</div>