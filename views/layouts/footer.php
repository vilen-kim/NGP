<?php
    use yii\helpers\Html;
?>

<footer class="container row center-block white">

    <div class="col-md-3">
        <div class="mediumGrayBold">Наименование</div>
        <div class="smallGray">Бюджетное учреждение Ханты-Мансийского автономного округа - Югры "Няганская городская поликлиника"</div>
    </div>
    <div class="col-md-2">
        <div class="mediumGrayBold">О поликлинике</div>
        <div><?= Html::a('Контакты', ['site/show', 'id' => 16], ['class' => 'white']) ?></div>
        <div><?= Html::a('Режим и график работы', ['site/show', 'id' => 17], ['class' => 'white']) ?></div>
        <div><?= Html::a('Цены на платные услуги', ['site/show', 'id' => 29], ['class' => 'white']) ?></div>
    </div>
    <div class="col-md-2">
        <div class="mediumGrayBold">Пациентам</div>
    </div>
    <div class="col-md-2">
        <div class="mediumGrayBold">Социальные сети</div>
        <div style="margin-top: 10px">
            <?php $height = 30; ?>
            <?= Html::a(Html::img('@web/images/icons/vk.svg', ['height' => $height]), 'https://vk.com/id433055831', ['title' => 'ВКонтакте', 'style' => 'margin-right: 5px;']) ?>
            <?= Html::a(Html::img('@web/images/icons/odnoklassniki.svg', ['height' => $height]), 'https://ok.ru/profile/571730537307', ['title' => 'Одноклассники', 'style' => 'margin-right: 5px;']) ?>
            <?= Html::a(Html::img('@web/images/icons/facebook.svg', ['height' => $height]), 'https://www.facebook.com/БУ-Няганская-городская-поликлиника-2189851657908954', ['title' => 'Facebook', 'style' => 'margin-right: 5px;']) ?>
            <?= Html::a(Html::img('@web/images/icons/twitter.svg', ['height' => $height]), 'https://twitter.com/profilngp1', ['title' => 'Twitter']) ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mediumGrayBold">Важная информация</div>
        <div class="smallGray">
            Телефон единой службы спасения:
            <span class="mediumGrayBold">112</span>
        </div>
        <div class="smallGray">
            Контакт-центр: <span class="mediumGrayBold">8-800-100-86-03</span>
        </div>

    </div>
</footer>

<?php
    $this->registerCss('
        #footerHolder {
            position: absolute;
            bottom: 0px;
            left: 0px;
            height: 100px;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
        }
        footer {
            height: 100%;
            padding: 10px;
        }
    ');