<?php
    use yii\helpers\Html;
    app\assets\SiteAsset::register($this);
    $this->title = 'Няганская городская поликлиника';
?>
<div class="site-index">
    
    <!-- Блок кнопок слева -->
    <div class="pull-left">
        <div id="btnRegister" class="btn btn-warning">Запись на прием</div><br>
        <div id="btnCallDoctor" class="btn btn-success">Вызов врача на дом</div><br>
        <div id="btnFeedback" class="btn btn-default">Обратная связь</div><br>
    </div>
    
    <!-- Блок социальных сетей справа -->
    <div class="pull-right">
        <?= Html::a(Html::img('@web/images/vk.svg'), 'https://vk.com/id433055831') ?>
        <?= Html::a(Html::img('@web/images/odnoklassniki.svg'), 'https://ok.ru/profile/571730537307') ?>
        <?= Html::a(Html::img('@web/images/facebook.svg'), 'https://www.facebook.com/БУ-Няганская-городская-поликлиника-2189851657908954') ?>
        <?= Html::a(Html::img('@web/images/twitter.svg'), 'https://twitter.com/profilngp1') ?>
    </div>
    
</div>