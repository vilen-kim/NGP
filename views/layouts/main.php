<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\components\MenuWidget;

app\assets\AppAsset::register($this);
?>



<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>



        <header class="container-fluid bg-primary">
            
            <!-- Логотип -->
            <div class="col-md-1">
                <?= Html::a(Html::img('@web/images/logo_white.gif', ['id' => 'logo', 'class' => 'scale']), Url::to(['site/index'])) ?>
            </div>
            
            <!-- Поиск -->
            <div class="col-md-4">
                <?= Html::textInput('text', '', ['class' => 'form-control', 'id' => 'searchText']) ?>
                <?= Html::a(Html::img('@web/images/search.svg', ['id' => 'searchImg', 'class' => 'scale']), '') ?>
            </div>
            
            <!-- Телефон -->
            <div class="col-md-4 col-md-offset-1">
                <snap id="phone">
                    Единый телефон 5-45-30
                    <?= Html::a(Html::img('@web/images/question.svg', ['id' => 'questionImg', 'class' => 'scale']), '') ?>
                </snap>
            </div>
            
            <!-- Меню -->
            <div class="col-md-1">
                <?= Html::a(Html::img('@web/images/menu.svg', ['id' => 'menuImg', 'class' => 'scale']), '', ['id' => 'menuLink']) ?>
            </div>

            <!-- Авторизация или выход -->
            <div class="col-md-1">
                <?php
                    if (Yii::$app->user->isGuest){
                        $img = Html::img('@web/images/login.svg', ['class' => 'scale', 'style' => 'height: 50px']);
                        $url = Url::to(['auth/login']);
                    } else {
                        $img = Html::img('@web/images/logout.svg', ['class' => 'scale', 'style' => 'height: 50px']);
                        $url = Url::to(['auth/logout']);
                    }
                    echo Html::a($img, $url);
                ?>
            </div>
        </header>

        

        <div class="container-fluid">
        <?php
            echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 'homeLink' => false]);
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                echo "<div class='alert alert-$key alert-dismissible'>$message</div>";
            }
            echo $content;
            echo MenuWidget::widget(['modal' => true]);
        ?>
        </div>
        



        <footer class="rows">
            <div class="col-md-3">
                <div style="font-size: small">Бюджетное учреждение Ханты-Мансийского автономного округа - Югры "Няганская городская поликлиника"</div>
            </div>
            <div class="col-md-3">
            </div>
            <div class="col-md-3">
                <?= Html::a(Html::img('@web/images/vk.svg', ['class' => 'moveUp']), 'https://vk.com/id433055831', ['title' => 'ВКонтакте']) ?>
                <?= Html::a(Html::img('@web/images/odnoklassniki.svg', ['class' => 'moveUp']), 'https://ok.ru/profile/571730537307', ['title' => 'Одноклассники']) ?>
                <?= Html::a(Html::img('@web/images/facebook.svg', ['class' => 'moveUp']), 'https://www.facebook.com/БУ-Няганская-городская-поликлиника-2189851657908954', ['title' => 'Facebook']) ?>
                <?= Html::a(Html::img('@web/images/twitter.svg', ['class' => 'moveUp']), 'https://twitter.com/profilngp1', ['title' => 'Twitter']) ?>
            </div>
            <div class="col-md-3">
                <div style="font-size: small">
                    Телефон единой службы спасения:
                    <span style="color: red; font-size: medium; font-weight: bold"><i><u>112</u></i></span>
                </div>
                <div style="font-size: small">
                    Контакт-центр: <span style="font-size: medium; font-weight: bold">8-800-100-86-03</span>
                </div>
            </div>
        </footer>



        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>