<?php

use yii\helpers\Html;
use yii\helpers\Url;

app\assets\AdminAsset::register($this);
$this->title = 'Панель управления';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="admin-index">
    
    <?php
        $array = [
            'auth' => [
                'count' => '<span class="badge">' . $count['auth'] . '</span>',
                'url' => !is_null($count['auth']) ? Url::to(['auth/index']) : '',
                'caption' => 'Пользователи',
                'options' => !is_null($count['auth']) ? ['class' => 'btn btn-success scale'] : ['class' => 'btn btn-default', 'disabled' => '', 'onClick' => 'return false;'],
            ],
            'menu' => [
                'count' => '<span class="badge">' . $count['menu'] . '</span>',
                'url' => !is_null($count['menu']) ? Url::to(['menu/index']) : '',
                'caption' => 'Меню',
                'options' => !is_null($count['menu']) ? ['class' => 'btn btn-primary scale'] : ['class' => 'btn btn-default', 'disabled' => '', 'onClick' => 'return false;'],
            ],
            'pages' => [
                'count' => '<span class="badge">' . $count['pages'] . '</span>',
                'url' => !is_null($count['pages']) ? Url::to(['pages/index', 'category_id' => 1]) : '',
                'caption' => 'Страницы',
                'options' => !is_null($count['pages']) ? ['class' => 'btn btn-info scale'] : ['class' => 'btn btn-default', 'disabled' => '', 'onClick' => 'return false;'],
            ],
            'news' => [
                'count' => '<span class="badge">' . $count['news'] . '</span>',
                'url' => !is_null($count['news']) ? Url::to(['pages/index', 'category_id' => 2]) : '',
                'caption' => 'Новости',
                'options' => !is_null($count['news']) ? ['class' => 'btn btn-info scale'] : ['class' => 'btn btn-default', 'disabled' => '', 'onClick' => 'return false;'],
            ],
            'articles' => [
                'count' => '<span class="badge">' . $count['articles'] . '</span>',
                'url' => !is_null($count['articles']) ? Url::to(['pages/index', 'category_id' => 3]) : '',
                'caption' => 'Статьи',
                'options' => !is_null($count['articles']) ? ['class' => 'btn btn-info scale'] : ['class' => 'btn btn-default', 'disabled' => '', 'onClick' => 'return false;'],
            ],
            'events' => [
                'count' => '<span class="badge">' . $count['events'] . '</span>',
                'url' => !is_null($count['events']) ? Url::to(['pages/index', 'category_id' => 4]) : '',
                'caption' => 'Мероприятия',
                'options' => !is_null($count['events']) ? ['class' => 'btn btn-info scale'] : ['class' => 'btn btn-default', 'disabled' => '', 'onClick' => 'return false;'],
            ],
        ];
        
        foreach ($array as $arr){
            echo Html::a($arr['caption'] . ' ' . $arr['count'], $arr['url'], $arr['options']) . '<br>';
        }
    ?>
</div>