<?php
    use yii\helpers\Html;    
?>

<footer class="container row center-block">

    <div class="col-md-3">
        <h3>Наименование</h3>
        <div>Бюджетное учреждение Ханты-Мансийского автономного округа - Югры "Няганская городская поликлиника"</div>
    </div>
    
    <div class="col-md-2">
        <h3>О поликлинике</h3>
        <div><?= Html::a('Контакты', ['site/show', 'id' => 16]) ?></div>
        <div><?= Html::a('Режим и график работы', ['site/show', 'id' => 17]) ?></div>
        <div><?= Html::a('Цены на платные услуги', ['site/show', 'id' => 29]) ?></div>
    </div>
    
    <div class="col-md-2">
        <h3>Пациентам</h3>
        <div><?= Html::a('Баннеры', ['site/banners']) ?></div>
    </div>
    
    <div class="col-md-2">
        <h3>Социальные сети</h3>
        <div id="footerSocial">
            <?php $height = 30; ?>
            <?= Html::a(Html::img('@web/images/icons/vk.svg', ['height' => $height]), 'https://vk.com/id433055831', ['title' => 'ВКонтакте', 'style' => 'margin-right: 5px;']) ?>
            <?= Html::a(Html::img('@web/images/icons/odnoklassniki.svg', ['height' => $height]), 'https://ok.ru/profile/571730537307', ['title' => 'Одноклассники', 'style' => 'margin-right: 5px;']) ?>
            <?= Html::a(Html::img('@web/images/icons/facebook.svg', ['height' => $height]), 'https://www.facebook.com/БУ-Няганская-городская-поликлиника-2189851657908954', ['title' => 'Facebook', 'style' => 'margin-right: 5px;']) ?>
            <?= Html::a(Html::img('@web/images/icons/twitter.svg', ['height' => $height]), 'https://twitter.com/profilngp1', ['title' => 'Twitter']) ?>
        </div>
    </div>
    
    <div class="col-md-3">
        <h3>Важная информация</h3>
        <div>
            Телефон единой службы спасения:
            <b>112</b>
        </div>
        <div>
            Контакт-центр: <b>8-800-100-86-03</b>
        </div>
    </div>
    
</footer>