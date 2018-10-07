<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
?>

<header class="container" id="header">

    <?php
    $img = Html::img('@web/images/logo_green.gif');
    NavBar::begin([
        'brandLabel' => '8 (34672) 5-45-30',
        'brandUrl' => ['site/mobile-phone'],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['site/index']],
            ['label' => 'Электронная регистратура', 'url' => 'https://er.dzhmao.ru/?setlocality=8600000500000'],
            ['label' => 'Вызов врача на дом', 'url' => ['site/call-doctor']],
            ['label' => 'Регистрация обращения', 'url' => ['site/request']],
            ['label' => 'Меню', 'url' => ['site/menu']],
            [
                'label' => Yii::$app->user->isGuest ? 'Вход' : 'Выход',
                'url' => Yii::$app->user->isGuest ? ['auth/login'] : ['auth/logout']
            ],
        ],
    ]);
    NavBar::end();
    ?>

</header>