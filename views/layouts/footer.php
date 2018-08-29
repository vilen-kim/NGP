<?php
    use yii\helpers\Html;
?>

<footer class="rows">
    <div class="col-md-3">
        <div class="mediumWhiteBold">Наименование</div>
        <div class="smallWhite">Бюджетное учреждение Ханты-Мансийского автономного округа - Югры "Няганская городская поликлиника"</div>
    </div>
    <div class="col-md-2">
        <div class="mediumWhiteBold">О поликлинике</div>
    </div>
    <div class="col-md-2">
        <div class="mediumWhiteBold">Пациентам</div>
    </div>
    <div class="col-md-3">
        <div class="mediumWhiteBold">Мы в социальных сетях</div>
        <div>
            <? Html::a(Html::img('@web/images/vk.svg', ['class' => 'moveUp']), 'https://vk.com/id433055831', ['title' => 'ВКонтакте']) ?>
            <? Html::a(Html::img('@web/images/odnoklassniki.svg', ['class' => 'moveUp']), 'https://ok.ru/profile/571730537307', ['title' => 'Одноклассники']) ?>
            <? Html::a(Html::img('@web/images/facebook.svg', ['class' => 'moveUp']), 'https://www.facebook.com/БУ-Няганская-городская-поликлиника-2189851657908954', ['title' => 'Facebook']) ?>
            <? Html::a(Html::img('@web/images/twitter.svg', ['class' => 'moveUp']), 'https://twitter.com/profilngp1', ['title' => 'Twitter']) ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mediumWhiteBold">Важная информация</div>
        <div style="font-size: small">
            Телефон единой службы спасения:
            <span style="color: red; font-size: medium; font-weight: bold"><i><u>112</u></i></span>
        </div>
        <div style="font-size: small">
            Контакт-центр: <span style="font-size: medium; font-weight: bold">8-800-100-86-03</span>
        </div>
    </div>
</footer>

<?php
    $this->registerCss('
        footer {
            position: absolute;
            bottom: 0;
            height: 90px;
            background: rgb(51,51,51);
            padding: 5px;
            color: white;
        }
    ');