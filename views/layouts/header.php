<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>

<header class="container-fluid bg-primary">

    <!-- Логотип -->
    <div class="col-md-1">
        <?= Html::a(Html::img('@web/images/logo_white.gif', ['id' => 'header_logo', 'class' => 'scale']), Url::to(['site/index'])) ?>
    </div>

    <!-- Поиск -->
    <div class="col-md-4">
        <div class="col-md-10">
            <?= Html::textInput('text', '', ['id' => 'header_searchText', 'class' => 'form-control']) ?>
        </div>
        <div class="col-md-2">
            <?= Html::a(Html::img('@web/images/search.svg', ['id' => 'header_searchImg', 'class' => 'scale']), '') ?>
        </div>
    </div>

    <!-- Телефон -->
    <div class="col-md-4 col-md-offset-1">
        <snap id="header_phone">
            Единый телефон 5-45-30
            <?= Html::a(Html::img('@web/images/question.svg', ['id' => 'header_questionImg', 'class' => 'scale']), '', ['id' => 'phoneLink']) ?>
        </snap>
    </div>

    <!-- Меню -->
    <div class="col-md-1">
        <?= Html::a(Html::img('@web/images/menu.svg', ['id' => 'header_menuImg', 'class' => 'scale']), '', ['id' => 'menuLink']) ?>
    </div>

    <!-- Авторизация или выход -->
    <div class="col-md-1">
        <?php
        if (Yii::$app->user->isGuest) {
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