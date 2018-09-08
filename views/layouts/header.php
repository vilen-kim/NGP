<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<header class="container">

    <?php
        $height = 40;
    ?>
    
    <!-- Логотип -->
    <div class="col-md-1">
        <?php
            $img = Html::img('@web/images/logo_green.gif', ['height' => 68, 'class' => 'scale']);
            echo Html::a($img, ['site/index']);
        ?>
    </div>

    
    
    <!-- Поиск -->
    <div class="col-md-1 col-md-offset-1" style="margin-top: 16px;">
        <?php
            $img = Html::img('@web/images/icons/search.svg', ['height' => $height, 'class' => 'scale']);
            echo Html::a($img, '');
        ?>
    </div>
    
    
    
    <!-- Телефон -->
    <div class="col-md-3" style='margin-top: 16px;'>
        <?php
            $img = Html::img('@web/images/icons/call.svg', ['height' => $height, 'class' => 'scale']);
            echo Html::a($img, '');
        ?>
        <span class="xx-large bold black" style="line-height: 1; margin-left: 10px;">5-45-30</span>
    </div>

    
    
    <!-- Кнопки основных действий -->
    <div class="col-md-6 row" id="headerButtons">
        <?php
            $class = "col-md-2 text-center showText";
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
                echo '' . Html::a("<span>$text</span>", '') . '';
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
                $text = 'Регистрация обращения';
                echo Html::img('@web/images/icons/request.svg', ['height' => $height]);
                echo '' . Html::a("<span>$text</span>", ['request/info']) . '';
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
                $text = 'Меню';
                echo Html::img('@web/images/icons/menu.svg', ['height' => $height]);
                echo '' . Html::a("<span>$text</span>", ['menu/show']) . '';
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
                echo '' . Html::a("<span>$text</span>", $url) . '';
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
                $text = 'Режим для слабовидящих';
                echo Html::img('@web/images/icons/eye.svg', ['height' => $height]);
                echo '' . Html::a("<span>$text</span>", '') . '';
            ?>
        </div>
    </div>
</header>

<?php
    $this->registerCss('
        header {
            height: 100%;
            padding-top: 5px;
        }
        #headerSearch {
            margin-left: 10px;
            background-color: transparent;
        }
        #headerButtons > div {
            height: 100%;
            margin-top: 10px;
            padding: 0px;
            
        }
        #headerButtons > div > a {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0px;
            text-align: center;
            display: none;
        }
    ');
    
    $this->registerJs('
        $("div.showText").hover(
            function(){
                $(this).children("img").css("opacity", "0.2");
                $(this).children("a").show();
            },
            function(){
                $(this).children("img").css("opacity", "1.0");
                $(this).children("a").hide();
                
            }
        );
    ');
        
