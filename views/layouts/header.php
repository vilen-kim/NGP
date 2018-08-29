<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use app\components\MenuItems;

?>

<header class="container row center-block">

    <!-- Логотип -->
    <div class="col-md-1">
        <?= Html::a(Html::img('@web/images/logo.png', ['height' => 80]), Url::to(['site/index'])) ?>
    </div>

    <!-- Телефон и поиск -->
    <div class="col-md-3 col-md-offset-1">
        <div style="margin-top: 2px;">
            <?= Html::a(Html::img('@web/images/call.svg', ['height' => 30]), '') ?>
            <span class="largeBold" style="line-height: 1; margin-left: 10px;">5-45-30</span>
        </div>
        <div style="margin-top: 10px;">
            <?= Html::a(Html::img('@web/images/search.svg', ['height' => 30]), '') ?>
            <?= Html::textInput('text', '', ['class' => 'textInput', 'size' => 15, 'style' => 'margin-left: 10px;']) ?>
        </div>
    </div>

    <!-- Меню и кнопки основных действий -->
    <div class="col-md-6">
        <div><?php
            $items = new MenuItems();
            echo Nav::widget([
                'items' => $items->array,
                'options' => [
                    'class' => 'nav-pills',
                    'style' => [
                        'margin-top' => '-6px',
                        'border-bottom' => '1px solid lightgray',
                    ],
                    'id' => 'menu',
                ],
            ]);
        ?></div>
        <div style="margin-top: 6px;" id="buttons">
            <div class="col-md-4" style="padding: 0px;">
                <?php
                    $img = Html::img('@web/images/registration.svg', ['height' => 30, 'style' => 'margin-top: 6px;']);
                    $content = "<div class='col-md-2'>$img</div>";
                    $content .= '<div class="col-md-8" style="padding-left: 20px">Электронная регистратура</div>';
                    echo Html::a($content, 'https://er.dzhmao.ru/?setlocality=8600000500000');
                ?>
            </div>
            <div class="col-md-4" style="padding: 0px;">
                <?php
                    $img = Html::img('@web/images/doctor.svg', ['height' => 30, 'style' => 'margin-top: 6px;']);
                    $content = "<div class='col-md-2'>$img</div>";
                    $content .= '<div class="col-md-8" style="padding-left: 20px">Вызов врача на дом</div>';
                    echo Html::a($content, '');
                ?>
            </div>
            <div class="col-md-4" style="padding: 0px;">
                <?php
                    $img = Html::img('@web/images/request.svg', ['height' => 30, 'style' => 'margin-top: 6px;']);
                    $content = "<div class='col-md-2'>$img</div>";
                    $content .= '<div class="col-md-8" style="padding-left: 20px">Регистрация обращения</div>';
                    echo Html::a($content, ['request/info']);
                ?>
            </div>
        </div>
    </div>

    <!-- Для слабовидящих и авторизация -->
    <div class="col-md-1">
        <div style="margin-top: 2px;">
            <?php
                if (Yii::$app->user->isGuest) {
                    $img = Html::img('@web/images/login.svg', ['style' => 'height: 30px']);
                    $url = Url::to(['auth/login']);
                } else {
                    $img = Html::img('@web/images/logout.svg', ['style' => 'height: 30px']);
                    $url = Url::to(['auth/logout']);
                }
                echo Html::a($img, $url);
            ?>
        </div>
        <div style="margin-top: 14px;">
            <?= Html::a(Html::img('@web/images/eye.svg', ['height' => 30]), '') ?>
        </div>
    </div>
</header>

<?php
    $this->registerCss('
        header {
            height: 94px;
            padding: 5px;
            border-bottom: 1px solid lightgray;
        }
        #menu ul {
            border-radius: 2px;
            max-width: 600px;
            overflow: auto;
            
        }
        #menu > li > a:hover {
            background: lightblue;
            border-radius: 2px;
        }
        #menu > li.open > a {
            background: lightgreen;
            border-radius: 2px;
        }
        #buttons > div:first-child {
            border-left: 1px solid lightgray;
        }
        #buttons > div {
            border-right: 1px solid lightgray;
        }
    ');