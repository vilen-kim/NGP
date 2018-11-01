<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;
if (!Yii::$app->mobileDetect->isMobile()){
    app\assets\SiteAsset::register($this);
}
$this->title = 'Няганская городская поликлиника';
?>



<!-- Джумботрон (только десктоп) -->
<?php
    if (!Yii::$app->mobileDetect->isMobile()){
        echo Html::tag('div', $this->title, ['class' => 'jumbotron']);
    } 
?>


        
<div id="site-index" class="container">



    <!-- Заголовок титульной страницы (только мобильная версия) -->
    <?php
        if (Yii::$app->mobileDetect->isMobile()){
            echo Html::tag('h1', $this->title, ['style' => 'font-size: xx-large; text-decoration: underline']);
        }
    ?>



    <!-- Виджет вызова врача на дом (только десктоп) -->
    <?php if (!Yii::$app->mobileDetect->isMobile()){ ?>
        <div class="callDoctor">
            <div class="col-sm-12 text-justify" style="margin-bottom: 20px;">
                <b>Показания для вызова врача-терапевта участкового:</b>
                повышение температуры тела выше 38,2 &degС;
                рвота, жидкий стул, боли в животе;
                острая боль любой локализации;
                болевой синдром у больных с ишемической болезнью сердца, состояние после пароксизмов нарушения ритма сердца, боли в сердце у больных с гипертонической болезнью и т.д.;
                колебания артериального давления на фоне гипертонической болезни, атеросклероза, стрессовых состояний;
                температура выше 38 &degC у парализованных больных и больных с хронической патологией.
            </div>
            <?php $form = ActiveForm::begin([
                'action' => ['site/call-doctor'],
                'fieldConfig' => [
                    'template' => "{input}",
                ],
            ]); ?>
            <div class="col-sm-12">
                <div class="col-sm-3">
                    <?= $form->field($model, 'fio')->textInput(['placeholder' => 'ФИО'])->label(false); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Номер телефона'])->label(false); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'address')->textInput(['placeholder' => 'Адрес'])->label(false); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Электронная почта'])->label(false); ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <?= $form->field($model, 'text')->textarea(['placeholder' => 'Опишите самочувствие'])->label(false); ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className())->label(false); ?>
                </div>
                <div class="col-sm-2" align="center">
                    <?= Html::submitButton('Отправить заявку', ['class' => 'btn btn-008080']) ?>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    <?php } ?>




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
            echo Html::tag('div', $contentHeader . $contentImg, ['style' => 'margin-top: 40px;']);
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