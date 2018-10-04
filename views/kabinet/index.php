<?php
use yii\helpers\Html;
app\assets\KabinetAsset::register($this);
$this->title = 'Личный кабинет';
$height = 70;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1 style="margin-bottom: 70px;"><?= $this->title ?></h1>

<div class="kabinet-index container">



    <!-- Этот блок видят все пользователи -->
    <div class="col-md-2 text-center showText">
        <?php
        echo Html::img("@web/images/icons/kabinet/request.svg", ['height' => $height]);
        $text = 'Работа с обращениями';
        echo Html::a("<span style='font-size: large'>$text</span>", ['kabinet/request']);
        ?>
    </div>
    <div class="col-md-2 text-center showText">
        <?php
        echo Html::img("@web/images/icons/kabinet/profile.svg", ['height' => $height]);
        $text = 'Профиль пользователя';
        echo Html::a("<span style='font-size: large'>$text</span>", ['kabinet/profile']);
        ?>
    </div>
    <!---->



    <?php
    if (Yii::$app->user->can('editor')){
        $array = [
            'callDoctor' => [
                'caption' => 'Регистрация вызова врача',
                'img' => '/images/icons/kabinet/adminDoctor.svg',
                'url' => Yii::$app->user->can('registrator') ? ['kabinet/call-doctor'] : '',
                'options' => Yii::$app->user->can('registrator') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3']
            ],
            'pages' => [
                'caption' => 'Страницы',
                'img' => '/images/icons/kabinet/adminPages.svg',
                'url' => Yii::$app->user->can('editor') ? ['pages/index'] : '',
                'options' => Yii::$app->user->can('editor') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
            ],
            'wall' => [
                'caption' => 'Записи из ВК',
                'img' => '/images/icons/kabinet/adminNews.svg',
                'url' => Yii::$app->user->can('editor') ? ['vk/get-wall'] : '',
                'options' => Yii::$app->user->can('editor') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
            ],
            'menu' => [
                'caption' => 'Меню',
                'img' => '/images/icons/kabinet/adminMenu.svg',
                'url' => Yii::$app->user->can('manager') ? ['menu/index'] : '',
                'options' => Yii::$app->user->can('manager') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
            ],
            'requests' => [
                'caption' => 'Обращения',
                'img' => '/images/icons/kabinet/adminRequest.svg',
                'url' => Yii::$app->user->can('manager') ? ['request/index'] : '',
                'options' => Yii::$app->user->can('manager') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
            ],
            'banners' => [
                'caption' => 'Баннеры',
                'img' => '/images/icons/kabinet/adminBanners.svg',
                'url' => Yii::$app->user->can('manager') ? ['banner/index'] : '',
                'options' => Yii::$app->user->can('manager') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
            ],
            'user' => [
                'caption' => 'Пользователи',
                'img' => '/images/icons/kabinet/adminUsers.svg',
                'url' => Yii::$app->user->can('admin') ? ['auth/index'] : '',
                'options' => Yii::$app->user->can('admin') ? '' : ['onClick' => 'return false;', 'style' => 'opacity: 0.3'],
            ],
        ];

        foreach ($array as $arr) {
            echo '<div class="col-md-2 text-center showText">';
            echo Html::img($arr['img'], ['height' => $height]);
            $text = $arr['caption'];
            echo Html::a("<span style='font-size: large'>$text</span>", $arr['url']);
            echo '</div>';
        }
    }
    ?>  

</div>