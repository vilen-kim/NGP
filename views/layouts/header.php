<?php

use yii\helpers\Html;
use yii\helpers\Url;

app\assets\HeaderAsset::register($this);
?>

<header class="container">

    <?php
    $eye = Yii::$app->session->get('eye');
    $iconPath = ($eye) ? 'icons/eye' : 'icons';
    $height = 45;
    $marginTop = (82 - $height) / 2 . 'px';
    echo $this->render("../modals/phone.php");
    ?>

    <!-- Логотип -->
    <div class="col-md-1 showText" style="margin-top: 7px">
        <?php
        $text = 'Главная';
        echo Html::img('@web/images/logo_green.gif', ['height' => 68]);
        echo Html::a("<span>$text</span>", ['site/index']);
        ?>
    </div>



    <!-- Поиск -->
    <div class="col-md-1 col-md-offset-1 showText" style="margin-top: <?= $marginTop ?>;">
        <?php
        $text = 'Показать/скрыть поиск';
        echo Html::img("@web/images/$iconPath/search.svg", ['height' => $height]);
        echo Html::a("<span>$text</span>", '', ['id' => 'headerSearch']);
        if ($eye){
            echo Html::textInput('text', '', ['id' => 'headerSearchInput', 'size' => 30, 'style' => 'background: rgb(50, 50, 50)']);
        } else {
            echo Html::textInput('text', '', ['id' => 'headerSearchInput', 'size' => 30]);
        }
        ?>
    </div>



    <!-- Телефон -->
    <div class="col-md-3" style='margin-top: 24px;'>
            <?= Html::a('<h2 style="margin-top: 0">8 (34672) 5-45-30</h2>', '', ['id' => 'headerPhone']) ?>
    </div>



    <!-- Кнопки основных действий -->
    <div class="col-md-6 row" id="headerButtons" style="margin-top: <?= $marginTop ?>">
        <?php
        $class = "col-md-2 showText";
        ?>
        <div class="<?= $class ?>">
            <?php
            $text = 'Электронная регистратура';
            echo Html::img("@web/images/$iconPath/registration.svg", ['height' => $height]);
            echo Html::a("<span>$text</span>", 'https://er.dzhmao.ru/?setlocality=8600000500000');
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = 'Вызов врача на дом';
            
            echo Html::img("@web/images/$iconPath/doctor.svg", ['height' => $height]);
            echo Html::a("<span>$text</span>", '');
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = 'Регистрация обращения';
            echo Html::img("@web/images/$iconPath/request.svg", ['height' => $height]);
            echo Html::a("<span>$text</span>", ['request/info']);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            if (Yii::$app->user->can('editor')){
                $img = Html::img("@web/images/$iconPath/menu3.svg", ['height' => $height]);
                $text = 'Меню, ЛК, Админ.';
            } else if (Yii::$app->user->can('user')){
                $img = Html::img("@web/images/$iconPath/menu2.svg", ['height' => $height]);
                $text = 'Меню, ЛК';
            } else {
                $img = Html::img("@web/images/$iconPath/menu1.svg", ['height' => $height]);
                $text = 'Меню';
            }
            echo $img;
            echo Html::a("<span>$text</span>", ['site/menu']);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = null;
            if (Yii::$app->user->isGuest) {
                $img = Html::img("@web/images/$iconPath/login.svg", ['height' => $height]);
                $url = Url::to(['auth/login']);
                $text = 'Вход';
            } else {
                $img = Html::img("@web/images/$iconPath/logout.svg", ['height' => $height]);
                $url = Url::to(['auth/logout']);
                $text = 'Выход';
            }
            echo $img;
            echo Html::a("<span>$text</span>", $url);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $img = Html::img("@web/images/$iconPath/eye.svg", ['height' => $height]);
            if (!$eye){
                $url = Url::to(['site/eye-on']);
                $text = 'Режим для слабовидящих';
            } else {
                $url = Url::to(['site/eye-off']);
                $text = 'Обычный режим';
            }
            echo $img;
            echo Html::a("<span>$text</span>", $url);
            ?>
        </div>
    </div>
</header>
