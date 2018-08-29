<?php
    use yii\helpers\Html;
?>

<div id="footerHolder">
    <footer class="container">
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
        <div class="col-md-2">
            <div class="mediumWhiteBold">Социальные сети</div>
            <div style="margin-top: 10px">
                <?php $height = 30; ?>
                <?= Html::a(Html::img('@web/images/vk.svg', ['height' => $height]), 'https://vk.com/id433055831', ['title' => 'ВКонтакте', 'style' => 'margin-right: 5px;']) ?>
                <?= Html::a(Html::img('@web/images/odnoklassniki.svg', ['height' => $height]), 'https://ok.ru/profile/571730537307', ['title' => 'Одноклассники', 'style' => 'margin-right: 5px;']) ?>
                <?= Html::a(Html::img('@web/images/facebook.svg', ['height' => $height]), 'https://www.facebook.com/БУ-Няганская-городская-поликлиника-2189851657908954', ['title' => 'Facebook', 'style' => 'margin-right: 5px;']) ?>
                <?= Html::a(Html::img('@web/images/twitter.svg', ['height' => $height]), 'https://twitter.com/profilngp1', ['title' => 'Twitter']) ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mediumWhiteBold">Важная информация</div>
            <div class="smallWhite">
                Телефон единой службы спасения:
                <span class="mediumWhiteBold">112</span>
            </div>
            <div class="smallWhite">
                Контакт-центр: <span class="mediumWhiteBold">8-800-100-86-03</span>
            </div>
        </div>
    </footer>
</div>

<?php
    $this->registerCss('
        #footerHolder {
            position: absolute;
            bottom: 0px;
            height: 90px;
            width: 100%;
        }
        footer {
            height: 100%;
            background: rgb(51,51,51);
            padding: 5px;
            color: white;
        }
    ');