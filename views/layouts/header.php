<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

?>

<header class="container" id="header">

    <!-- Украшение на Новый Год 
    <div id="garland" class="garland_4">
        <div id="nums_1">1</div>
    </div>
    -->


    <?php
    $img = Html::img('@web/images/logo_green.gif');
    $height = Yii::$app->mobileDetect->isMobile() ? '50px' : '110px';
    $special_version = Yii::$app->request->cookies->getValue('special_version');
    NavBar::begin([
        'brandLabel' => (!$special_version) ? Html::img('@web/images/logo.png', ['height' => $height]) : '',
        'brandUrl' => ['site/index'],
        'brandOptions' => ['style' => 'padding: 0'],
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);

    $url = !Yii::$app->mobileDetect->isMobile() ? '' : ['site/mobile-phone'];
    echo Html::a('8 (34672) 5-45-30', $url, ['id' => 'headerPhone', 'class' => 'dot']);
    echo Html::a('8 9828720741 - Главный врач Заманов Ильмир Ильгизарович <br>', $url, ['id' => 'headerPhone', 'class' => 'dot']);
    echo ('                                     ');
    echo Html::a('8 9828720742 - И.о. зам. главного врача по мед. части Магомедов Чингис Мусаевич', $url, ['id' => 'headerPhone', 'class' => 'dot']);
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
                'options' => [
                    'id' => 'menu',
                    'style' => !Yii::$app->mobileDetect->isMobile() ? 'padding-top: 10px' : ''
                ],
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
                'label' => Yii::$app->user->isGuest ?
                    !Yii::$app->mobileDetect->isMobile() ? 'Вход в<br>личный кабинет' : 'Вход в личный кабинет' :
                    'Выход',
                'url' => Yii::$app->user->isGuest ? ['auth/login'] : ['auth/logout'],
            ],
            [
                'label' => ($special_version == 1) ?
                    Html::img('@web/images/icons/eyeOff.svg', ['height' => 25, 'style' => 'margin-bottom: -5px;']) . 'Обычный<br>режим' :
                    Html::img('@web/images/icons/eyeOn.svg', ['height' => 25, 'style' => 'margin-bottom: -5px;']) . ' Версия для<br>слабовидящих',
                'url' => ($special_version == 1) ? ['site/eye-off', 'page' => Url::current()] : ['site/eye-on', 'page' => Url::current()],
                'visible' => !Yii::$app->mobileDetect->isMobile() ? true : false,
            ],
        ],
    ]);
    NavBar::end();

    echo $this->render('../modals/phone.php');
    echo $this->render('../modals/doctor.php') ;

    // Отображаем специальную панель для слабовидящих
    if ($special_version == 1){
        Yii::$app->view->registerCssFile('/css/layout/eyepanel.css');
        Yii::$app->view->registerJsFile('/js/layout/eyepanel.js', ['depends' => ['yii\web\YiiAsset']]);
        echo \app\components\EyePanel::widget();
    }

    ?>

</header>