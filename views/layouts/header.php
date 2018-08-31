<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use app\components\MenuItems;

?>

<div class="container-fluid" id="headerHolder">
    <header class="container row center-block">

        <!-- Логотип -->
        <div class="col-md-1">
            <?= Html::a(Html::img('@web/images/logo.png', ['height' => 92, 'class' => 'backGray']), Url::to(['site/index'])) ?>
        </div>

        <!-- Телефон и поиск -->
        <div class="col-md-3 col-md-offset-1">
            <div style="margin-top: 6px;">
                <?= Html::a(Html::img('@web/images/icons/call.svg', ['height' => 30, 'class' => 'backGray']), '') ?>
                <span class="largeBold" style="line-height: 1; margin-left: 10px;">5-45-30</span>
            </div>
            <div style="margin-top: 12px;">
                <?= Html::a(Html::img('@web/images/icons/search.svg', ['height' => 30, 'class' => 'backGray']), '') ?>
                <?= Html::textInput('text', '', ['class' => 'textInput', 'size' => 15, 'style' => 'margin-left: 10px;']) ?>
            </div>
        </div>

        <!-- Меню и кнопки основных действий -->
        <div class="col-md-6">
            <div>
            <?php
                $menu = new MenuItems();
                echo Nav::widget([
                    'items' => $menu->items,
                    'options' => [
                        'class' => 'nav-pills',
                        'style' => [
                            'margin-top' => '-6px',
                            'border-bottom' => '1px solid lightgray',
                        ],
                        'id' => 'headerMenu',
                    ],
                ]);
            ?>
            </div>
            <div class="row" style="margin-top: 6px;" id="headerButtons">
                <div class="col-md-4 backGray">
                    <?php
                        $img = Html::img('@web/images/icons/registration.svg', ['height' => 30, 'style' => 'margin-top: 6px;']);
                        $content = "<div class='col-md-2'>$img</div>";
                        $content .= '<div class="col-md-8" style="padding-left: 20px">Электронная регистратура</div>';
                        echo Html::a($content, 'https://er.dzhmao.ru/?setlocality=8600000500000');
                    ?>
                </div>
                <div class="col-md-4 backGray">
                    <?php
                        $img = Html::img('@web/images/icons/doctor.svg', ['height' => 30, 'style' => 'margin-top: 6px;']);
                        $content = "<div class='col-md-2'>$img</div>";
                        $content .= '<div class="col-md-8" style="padding-left: 20px">Вызов врача на дом</div>';
                        echo Html::a($content, '');
                    ?>
                </div>
                <div class="col-md-4 backGray">
                    <?php
                        $img = Html::img('@web/images/icons/request.svg', ['height' => 30, 'style' => 'margin-top: 6px;']);
                        $content = "<div class='col-md-2'>$img</div>";
                        $content .= '<div class="col-md-8" style="padding-left: 20px">Регистрация обращения</div>';
                        echo Html::a($content, ['request/info']);
                    ?>
                </div>
            </div>
        </div>

        <!-- Для слабовидящих и авторизация -->
        <div class="col-md-1">
            <div style="margin-top: 6px;">
                <?php
                    if (Yii::$app->user->isGuest) {
                        $img = Html::img('@web/images/icons/login.svg', ['height' => 30, 'class' => 'backGray']);
                        $url = Url::to(['auth/login']);
                    } else {
                        $img = Html::img('@web/images/icons/logout.svg', ['height' => 30, 'class' => 'backGray']);
                        $url = Url::to(['auth/logout']);
                    }
                    echo Html::a($img, $url);
                ?>
            </div>
            <div style="margin-top: 14px;">
                <?= Html::a(Html::img('@web/images/icons/eye.svg', ['height' => 30, 'class' => 'backGray']), '') ?>
            </div>
        </div>
    </header>
</div>

<?php
    $this->registerCss('
        #headerHolder {
            height: 94px;
            border-bottom: 1px solid lightgray;
            width: 100%;
        }
        header {
            height: 100%
            padding: 5px;
        }
        #headerMenu > li > a {
            padding: 12px 10px;
            margin-left: 4px;
        }
        #headerMenu > li > a:hover {
            background: #a3da41;
            border-radius: 2px;
        }
        #headerMenu > li.open > a {
            background: #a3da41;
            border-radius: 2px;
        }
        #headerMenu ul {
            border-radius: 2px;
            max-width: 600px;
            overflow: auto;
        }
        #headerButtons > div {
            padding: 0px 0px 0px 22px;
        }
        #headerButtons > div div {
            padding: 0px;
        }
    ');