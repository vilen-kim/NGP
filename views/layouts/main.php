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
            <div class="col-md-1">
                <?= Html::a(Html::img('@web/images/logo_white.gif', ['id' => 'logo', 'class' => 'scale']), Url::to(['site/index'])) ?>
            </div>
            <div class="col-md-4">
                <?= Html::textInput('text', '', ['class' => 'form-control', 'id' => 'searchText']) ?>
                <?= Html::a(Html::img('@web/images/search.svg', ['id' => 'searchImg', 'class' => 'scale']), '') ?>
            </div>
            <?php if (Yii::$app->user->isGuest) { ?>
            <div class="col-md-4 col-md-offset-2">
            <?php } else { ?>
            <div class="col-md-4 col-md-offset-1">
            <?php } ?>
                <snap id="phone">
                    Единый телефон 5-45-30
                    <?= Html::a(Html::img('@web/images/question.svg', ['id' => 'questionImg', 'class' => 'scale']), '') ?>
                </snap>
            </div>
            <div class="col-md-1">
                <?= Html::a(Html::img('@web/images/menu.svg', ['id' => 'menuImg', 'class' => 'scale']), '', ['id' => 'menuLink']) ?>
            </div>
            <?php if (!Yii::$app->user->isGuest) { ?>
            <div class="col-md-1">
                <?= Html::a(Html::img('@web/images/logout.svg', ['id' => 'logoutImg', 'class' => 'scale']), Url::to(['auth/logout']), ['id' => 'logoutLink']) ?>
            </div>
            <?php } ?>
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