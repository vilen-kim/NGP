<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>

<header class="container" id="header">

    <?php
        $height = 45;
        $marginTop = (82 - $height) / 2 . 'px';
        echo $this->render("../modals/phone.php");
    ?>

    <!-- Логотип -->
    <div class="col-sm-1 showText" style="margin-top: 7px">
        <?php
        $text = 'Няганская городская поликлиника';
        echo Html::img('@web/images/logo_green.gif', ['height' => 68]);
        echo Html::a("<span>$text</span>", ['site/index']);
        ?>
    </div>



    <!-- Телефон -->
    <div class="col-sm-4 col-sm-offset-1" style='margin-top: 24px;'>
        <h2 style="margin-top: 0">
            <?= Html::a('8 (34672) 5-45-30', '', ['id' => 'headerPhone', 'class' => 'dot']) ?>
        </h2>
    </div>



    <!-- Кнопки основных действий -->
    <div class="col-sm-6 row" id="headerButtons" style="margin-top: <?= $marginTop ?>">
        <?php
        $class = "col-sm-2 showText";
        ?>
        <div class="<?= $class ?>">
            <?php
            $text = 'Электронная регистратура';
            echo Html::img("@web/images/icons/registration.svg", ['height' => $height]);
            echo Html::a("<span>$text</span>", 'https://er.dzhmao.ru/?setlocality=8600000500000');
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = 'Вызов врача на дом';
            echo Html::img("@web/images/icons/doctor.svg", ['height' => $height]);
            echo Html::a("<span>$text</span>", ['site/call-doctor']);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = 'Регистрация обращения';
            echo Html::img("@web/images/icons/request.svg", ['height' => $height]);
            echo Html::a("<span>$text</span>", ['site/request']);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            if (Yii::$app->user->can('editor')){
                $img = Html::img("@web/images/icons/menu3.svg", ['height' => $height]);
            } else if (Yii::$app->user->can('user')){
                $img = Html::img("@web/images/icons/menu2.svg", ['height' => $height]);
            } else {
                $img = Html::img("@web/images/icons/menu1.svg", ['height' => $height]);
            }
            $text = 'Меню';
            echo $img;
            echo Html::a("<span>$text</span>", ['site/menu']);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            $text = null;
            if (Yii::$app->user->isGuest) {
                $img = Html::img("@web/images/icons/login.svg", ['height' => $height]);
                $url = Url::to(['auth/login']);
                $text = 'Вход';
            } else {
                $img = Html::img("@web/images/icons/logout.svg", ['height' => $height]);
                $url = Url::to(['auth/logout']);
                $text = 'Выход';
            }
            echo $img;
            echo Html::a("<span>$text</span>", $url);
            ?>
        </div>
        <div class="<?= $class ?>">
            <?php
            if (!Yii::$app->session->get('eye')){
                $text = 'Режим для слабовидящих';
                $class = 'toOn';
                $img = Html::img("@web/images/icons/eyeOn.svg", ['height' => $height]);
            } else {
                $text = 'Обычный режим';
                $class = 'toOff';
                $img = Html::img("@web/images/icons/eyeOff.svg", ['height' => $height]);
            }
            echo $img;
            echo Html::a(Html::tag('span', $text), '', ['class' => $class, 'id' => 'headerEye']);
            ?>
        </div>
    </div>
</header>
