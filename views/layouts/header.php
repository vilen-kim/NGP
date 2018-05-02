<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>

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