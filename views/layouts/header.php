<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
?>

<header class="container" id="header">

    <?php
    $img = Html::img('@web/images/logo_green.gif');
    $height = Yii::$app->mobileDetect->isMobile() ? '50px' : '110px';
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo.png', ['height' => $height]),
        'brandUrl' => ['site/index'],
        'brandOptions' => ['style' => 'padding: 0'],
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);

    $url = !Yii::$app->mobileDetect->isMobile() ? '' : ['site/mobile-phone'];
    echo Html::a('8 (34672) 5-45-30', $url, ['id' => 'headerPhone', 'class' => 'dot']);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            [
                'label' => 'Главная',
                'url' => ['site/index'],
                'options' => !Yii::$app->mobileDetect->isMobile() ? ['style' => 'padding-top: 10px'] : [],
            ],
            [
                'label' => 'Меню',
                'url' => ['site/menu'],
                'options' => ['id' => 'menu', 'style' => !Yii::$app->mobileDetect->isMobile() ? 'padding-top: 10px' : ''],
            ],
            [
                'label' => !Yii::$app->mobileDetect->isMobile() ? 'Электронная<br>регистратура' : 'Электронная регистратура',
                'url' => 'https://er.dzhmao.ru/?setlocality=8600000500000',
            ],
            [
                'label' => 'Вызов врача на дом',
                'url' => ['site/call-doctor'],
                'visible' => !Yii::$app->mobileDetect->isMobile() ? false : true,
            ],
            [
                'label' => !Yii::$app->mobileDetect->isMobile() ? 'Регистрация<br>обращения' : 'Регистрация обращения',
                'url' => ['site/request'],
            ],
            [
                'label' => isset(Yii::$app->session['eye']) ? 'Обычный<br>режим' : 'Версия для<br>слабовидящих',
                'url' => '#',
                'visible' => !Yii::$app->mobileDetect->isMobile() ? true : false,
                'options' => ['id' => 'headerEye', 'class' => isset(Yii::$app->session['eye']) ? 'toOff' : 'toOn'],
            ],
            [
                'label' => Yii::$app->user->isGuest ? 
                            !Yii::$app->mobileDetect->isMobile() ? 'Вход в<br>личный кабинет' : 'Вход в личный кабинет' :
                            'Выход',
                'url' => Yii::$app->user->isGuest ? ['auth/login'] : ['auth/logout'],
            ],
        ],
    ]);
    NavBar::end();
    echo $this->render('../modals/phone.php');
    ?>

</header>