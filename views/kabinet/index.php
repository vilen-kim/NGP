<?php
use yii\helpers\Html;
app\assets\KabinetAsset::register($this);
$this->title = 'Личный кабинет';
if (!Yii::$app->mobileDetect->isMobile()){
    $image = ['height' => 70];
    $style = 'col-sm-2 text-center showText';
    $div = 'row';
} else {
    $image = ['width' => 30, 'style' => 'margin: 0 10px 10px 0'];
    $style = '';
    $div = '';
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="kabinet-index container">



    <!-- Этот блок видят все пользователи -->
    <div class="<?= $div ?>">
        <h2 align="center">Пользователь</h2>
        <div class="<?= $style ?>">
            <?php
            echo Html::img("@web/images/icons/kabinet/request.svg", $image);
            $text = 'Работа с обращениями';
            echo Html::a("<span style='font-size: large'>$text</span>", ['kabinet/request']);
            ?>
        </div>
        <div class="<?= $style ?>">
            <?php
            echo Html::img("@web/images/icons/kabinet/profile.svg", $image);
            $text = 'Профиль пользователя';
            echo Html::a("<span style='font-size: large'>$text</span>", ['kabinet/profile']);
            ?>
        </div>
        <div class="<?= $style ?>">
            <?php
            if (Yii::$app->user->can('registrator')){
                echo Html::img("@web/images/icons/kabinet/doctor.svg", $image);
                $text = 'Регистрация вызова врача';
                echo Html::a("<span style='font-size: large'>$text</span>", ['call-doctor/index']);
            }
            ?>
        </div>
    </div>
    <!---->


    <?php
    if (Yii::$app->user->can('editor')){
        echo Html::beginTag('div', ['class' => $div]);
        echo Html::tag('h2', 'Администрирование', ['align' => 'center']);
        $array = [
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
            echo Html::beginTag('div', ['class' => $style]);
                echo Html::img($arr['img'], $image);
                $text = $arr['caption'];
                echo Html::a("<span style='font-size: large'>$text</span>", $arr['url']);
            echo Html::endTag('div');
        }
        echo Html::endTag('div');
    }
    ?> 

</div>