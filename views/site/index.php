<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
if (!Yii::$app->mobileDetect->isMobile()){
    app\assets\SiteAsset::register($this);
}
$this->title = 'Главная';
?>

<!-- Эффект параллакса (только на десктопах) -->
<?php
    // if (!Yii::$app->mobileDetect->isMobile() && !Yii::$app->session->get('eye')){
    //     echo Html::beginTag('div', [
    //         'class'               => 'parallax-window',
    //         'data-parallax'       => 'scroll',
    //         'data-image-src'      => '/images/backgrounds/parallax.jpg',
    //         'data-natural-width'  => 1920,
    //         'data-natural-height' => 1080,
    //         'data-speed'          => 0.2,
    //     ]);
    //     echo Html::beginTag('div', ['id' => 'parallaxWhite']);
    // }
?>

<div class="jumbotron">
    Няганская городская поликлиника
</div>
        
<div id="site-index" class="container">



    <!-- Виджет вызова врача на дом -->
    <div class="callDoctor">
        <div class="col-sm-12" style="margin-bottom: 20px;">
            <b>Показания для вызова врача-терапевта участкового:</b>
            повышение температуры тела выше 38,2 &degС;
            рвота, жидкий стул, боли в животе;
            острая боль любой локализации;
            болевой синдром у больных с ишемической болезнью сердца, состояние после пароксизмов нарушения ритма сердца, боли в сердце у больных с гипертонической болезнью и т.д.;
            колебания артериального давления на фоне гипертонической болезни, атеросклероза, стрессовых состояний;
            температура выше 38 &degC у парализованных больных и больных с хронической патологией.
        </div>
        <?php $form = ActiveForm::begin(['action' => ['site/call-doctor']]); ?>
        <div class="col-sm-3">
            <?= $form->field($model, 'fio')->textInput(['placeholder' => 'ФИО'])->label(false); ?>
            <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Номер телефона'])->label(false); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'address')->textInput(['placeholder' => 'Адрес'])->label(false); ?>
            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Электронная почта'])->label(false); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'text')->textarea(['placeholder' => 'Опишите самочувствие'])->label(false); ?>
        </div>
        <div class="col-sm-2" align="center">
            <?= Html::submitButton('Отправить заявку', ['class' => 'btn btn-008080']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>



    <h1>Последние новости</h1>

    <?php

    // Десктоп
    if (!Yii::$app->mobileDetect->isMobile()){
        echo Html::beginTag('div', ['class' => 'news']);
        for ($i = 0; $i < count($news); $i++){
            if ($i % 2 == 1) {
                $contentLeft = Html::img($news[$i]->image);
                $contentRight = Html::tag('h2', Html::a($news[$i]->caption, ['site/show', 'id' => $news[$i]->id]));
            } else {
                $contentLeft = Html::tag('h2', Html::a($news[$i]->caption, ['site/show', 'id' => $news[$i]->id]));
                $contentRight = Html::img($news[$i]->image);
            }
            $left = Html::tag('div', $contentLeft, ['class' => 'col-sm-5 animated fadeInLeft']);
            $right = Html::tag('div', $contentRight, ['class' => 'col-sm-5 col-sm-offset-2 animated fadeInRight']);
            echo Html::tag('div', $left . $right, ['class' => 'col-sm-10 col-sm-offset-1 row animatedParent animateOnce']);
        }
        echo Html::endTag('div');

    // Мобильное устройство
    } else {
        for ($i = 0; $i < count($news); $i++){
            $contentHeader = Html::tag('h2', Html::a($news[$i]->caption, ['site/show', 'id' => $news[$i]->id]));
            $contentImg = Html::img($news[$i]->image, ['width' => '100%']);
            echo Html::tag('div', $contentHeader . $contentImg);
        }
    }
    ?>

    <?php
    if (!Yii::$app->mobileDetect->isMobile()){
        echo Html::beginTag('div', ['class' => 'banners']);
        echo Html::beginTag('div', ['class' => 'row']);
        for ($i = 0; $i < count($banners); $i++){
            $banner = $banners[$i];
            $img = Html::img($banner->image, ['class' => 'scale', 'style' => 'box-shadow: 1px 1px 2px gray', 'width' => '100%']);
            $url = $banner->url;
            echo Html::tag('div', Html::a($img, $url), ['class' => 'col-sm-2']);
            if (($i+1) % 6 == 0) {
                echo Html::endTag('div');
                echo Html::beginTag('div', ['class' => 'row']);
            }
        }
        echo Html::endTag('div');
        echo Html::endTag('div');
    } else {
        echo Html::tag('h2', 'Баннеры', ['align' => 'center']);
        for ($i = 0; $i < count($banners); $i++){
            $banner = $banners[$i];
            $img = Html::img($banner->image, ['style' => 'width: 200px; border: 1px solid gray']);
            $url = $banner->url;
            echo Html::tag('div', Html::a($img, $url), ['style' => 'margin-bottom: 10px; text-align: center']);
        }
    }
    ?>

</div>
        
<?php
    // if (!Yii::$app->mobileDetect->isMobile() && !Yii::$app->session->get('eye')){
    //     echo Html::endTag('div');
    //     echo Html::endTag('div');
    // }
?>