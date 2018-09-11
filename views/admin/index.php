<?php
    use yii\helpers\Html;
    app\assets\AdminAsset::register($this);
    $this->title = 'Панель управления';
?>

<h1><?= $this->title ?></h1>

<div class="container">

    <?php
    $height = 80;
    $array = [
        'user' => [
            'caption' => 'Пользователи',
            'img' => '/images/icons/admin/users.svg',
            'count' => '<span class="badge">' . $count['users'] . '</span>',
            'url' => Yii::$app->user->can('admin') ? ['auth/index'] : '',
            'options' => Yii::$app->user->can('admin') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
        ],
        'menu' => [
            'caption' => 'Меню',
            'img' => '/images/icons/admin/menu3.svg',
            'count' => '<span class="badge">' . $count['menu'] . '</span>',
            'url' => Yii::$app->user->can('manager') ? ['menu/index'] : '',
            'options' => Yii::$app->user->can('manager') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
        ],
        'pages' => [
            'caption' => 'Страницы',
            'img' => '/images/icons/admin/pages.svg',
            'count' => '<span class="badge">' . $count['pages'] . '</span>',
            'url' => Yii::$app->user->can('editor') ? ['pages/index'] : '',
            'options' => Yii::$app->user->can('editor') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
        ],
        'requests' => [
            'caption' => 'Обращения',
            'img' => '/images/icons/admin/request.svg',
            'count' => '<span class="badge">' . $count['requests'] . '</span>',
            'url' => Yii::$app->user->can('manager') ? ['request/index'] : '',
            'options' => Yii::$app->user->can('manager') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
        ],
        'wall' => [
            'caption' => 'Записи из ВК',
            'img' => '/images/icons/admin/news.svg',
            'count' => '<span class="badge">' . $count['wall'] . '</span>',
            'url' => Yii::$app->user->can('editor') ? ['admin/get-wall'] : '',
            'options' => Yii::$app->user->can('editor') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
        ],
        'banners' => [
            'caption' => 'Баннеры',
            'img' => '/images/icons/admin/banners.svg',
            'count' => '<span class="badge">' . $count['banners'] . '</span>',
            'url' => Yii::$app->user->can('manager') ? ['banners/index'] : '',
            'options' => Yii::$app->user->can('manager') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
        ],
    ];
    
    foreach ($array as $arr) {
        echo '<div class="col-md-2 text-center showText">';
            echo Html::img($arr['img'], ['height' => $height]);
            $text = $arr['caption'];
            echo Html::a("<span style='font-size: large'>$text</span>", $arr['url']);
        echo '</div>';
    }
    ?>
</div>