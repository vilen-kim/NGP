<?php

use yii\helpers\Html;
use yii\helpers\Url;

app\assets\HeaderAsset::register($this);
?>

<header class="container">

    <?php
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
        echo Html::img('@web/images/icons/search.svg', ['height' => $height]);
        echo Html::a("<span>$text</span>", '', ['id' => 'headerSearch']);
        echo Html::textInput('text', '', ['id' => 'headerSearchInput', 'size' => 30]);
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
            echo Html::img('@web/images/icons/registration.svg', ['height' => $height]);
            echo Html::a("<span>$text</span>", 'https://er.dzhmao.ru/?setlocality=8600000500000');
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = 'Вызов врача на дом';
            echo Html::img('@web/images/icons/doctor.svg', ['height' => $height]);
            echo Html::a("<span>$text</span>", '');
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = 'Регистрация обращения';
            echo Html::img('@web/images/icons/request.svg', ['height' => $height]);
            echo Html::a("<span>$text</span>", ['request/info']);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = 'Меню';
            echo Html::img('@web/images/icons/menu.svg', ['height' => $height]);
            echo Html::a("<span>$text</span>", ['site/menu']);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = null;
            if (Yii::$app->user->isGuest) {
                $img = Html::img('@web/images/icons/login.svg', ['height' => $height]);
                $url = Url::to(['auth/login']);
                $text = 'Вход';
            } else {
                $img = Html::img('@web/images/icons/logout.svg', ['height' => $height]);
                $url = Url::to(['auth/logout']);
                $text = 'Выход';
            }
            echo $img;
            echo Html::a("<span>$text</span>", $url);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = 'Режим для слабовидящих';
            echo Html::img('@web/images/icons/eye.svg', ['height' => $height]);
            echo Html::a("<span>$text</span>", '');
            ?>
        </div>
    </div>
</header>
