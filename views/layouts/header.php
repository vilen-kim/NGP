<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<header class="container row center-block">

    
    
    <!-- Логотип -->
    <div class="col-md-1">
        <?php
            $img = Html::img('@web/images/logo.png', ['height' => 68, 'class' => 'scale']);
            echo Html::a($img, ['site/index']);
        ?>
    </div>

    
    
    <!-- Поиск -->
    <div class="col-md-2 col-md-offset-1" style="margin-top: 16px;">
        <?php
            $img = Html::img('@web/images/icons/search.svg', ['height' => 30, 'class' => 'scale']);
            echo Html::a($img, '');
            echo Html::textInput('text', '', ['class' => 'textInput', 'id' => 'headerSearch', 'size' => 10]);
        ?>
    </div>
    
    
    
    <!-- Телефон -->
    <div class="col-md-2" style='margin-top: 16px;'>
        <?php
            $img = Html::img('@web/images/icons/call.svg', ['height' => 30, 'class' => 'scale']);
            echo Html::a($img, '');
        ?>
        <span class="xx-large bold black" style="line-height: 1; margin-left: 10px;">5-45-30</span>
    </div>

    
    
    <!-- Кнопки основных действий -->
    <div class="col-md-6 row" id="headerButtons">
        <div class="col-md-2 text-center">
            <?php
                $text = 'Электронная регистратура';
                $img = Html::img('@web/images/icons/registration.svg', ['height' => 50, 'id' => 'hb1']);
                $imgHover = Html::img('@web/images/icons/registrationHover.svg', ['height' => 50, 'id' => 'hb1H', 'class' => 'hidden']);
                echo Html::a($img, 'https://er.dzhmao.ru/?setlocality=8600000500000');
                echo Html::a($imgHover, 'https://er.dzhmao.ru/?setlocality=8600000500000');
                echo "<span>$text</span>";
            ?>
        </div>
        <div class="col-md-2 text-center">
            <?php
                $text = 'Вызов врача на дом';
                $img = Html::img('@web/images/icons/doctor.svg', ['height' => 50]);
                echo Html::a($img, '');
                echo "<span>$text</span>";
            ?>
        </div>
        <div class="col-md-2 text-center">
            <?php
                $text = 'Регистрация обращения';
                $img = Html::img('@web/images/icons/request.svg', ['height' => 50]);
                echo Html::a($img, ['request/info']);
                echo "<span>$text</span>";
            ?>
        </div>
        <div class="col-md-2 text-center">
            <?php
                $text = 'Меню';
                $img = Html::img('@web/images/icons/menu.svg', ['height' => 50]);
                echo Html::a($img, ['menu/show']);
                echo "<span>$text</span>";
            ?>
        </div>
        <div class="col-md-2 text-center">
            <?php
                $text = null;
                if (Yii::$app->user->isGuest) {
                    $img = Html::img('@web/images/icons/login.svg', ['height' => 50]);
                    $url = Url::to(['auth/login']);
                    $text = 'Вход';
                } else {
                    $img = Html::img('@web/images/icons/logout.svg', ['height' => 50]);
                    $url = Url::to(['auth/logout']);
                    $text = 'Выход';
                }
                echo Html::a($img, $url);
                echo "<span>$text</span>";
            ?>
        </div>
        <div class="col-md-2 text-center">
            <?php
                $text = 'Режим для слабовидящих';
                $img = Html::img('@web/images/icons/eye.svg', ['height' => 50]);
                echo Html::a($img, '');
                echo "<span>$text</span>";
            ?>
        </div>
    </div>
</header>

<?php
    $this->registerCss('
        #headerHolder {
            height: 82px;
            width: 100%;
            margin: 0px;
            background: rgba(255, 255, 255, 0.3);
        }
        header {
            height: 100%;
            padding-top: 5px;
        }
        #headerSearch {
            margin-left: 10px;
            background-color: transparent;
        }
        #headerButtons > div {
            margin-top: 10px;
            padding: 0px;
        }
        #headerButtons > div > a > img {
            position: absolute;
            top: 0px;
        }
        #headerButtons > div > span {
            position: absolute;
            left: 0px;
            top: 20px;
            display: none;
        }
    ');
    
    $this->registerJs('
        $("#hb1").hover(
            function(){
                $("#hb1").addClass("hidden");
                $("#hb1H").removeClass("hidden");
            },
            function(){
                $("#hb1").removeClass("hidden");
                $("#hb1H").addClass("hidden");
            }
        );
    ');