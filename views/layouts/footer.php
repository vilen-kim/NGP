<?php
    use yii\helpers\Html;    
?>

<footer class="container row center-block">

    <div class="col-sm-3">
        <h3>Наименование</h3>
        <div>Бюджетное учреждение Ханты-Мансийского автономного округа - Югры "Няганская городская поликлиника"</div>
        <div style="margin-top: 10px;">
            <?php
                $url = 'https://metrika.yandex.ru/stat/?id=50670112&amp;from=informer';
                $style = 'width: 88px; height: 31px; border: 0';
                $src = 'https://informer.yandex.ru/informer/50670112/3_1_FFFFFFFF_EFEFEFFF_0_pageviews';
                $img = Html::img($src, [
                    'style'     => $style,
                    'class'     => 'ym-advanced-informer',
                    'data-cid'  => '50670112',
                    'data-lang' => 'ru',
                ]);
                echo Html::a($img, $url);
            ?>
        </div>
    </div>
    
    <div class="col-sm-2">
        <h3>О поликлинике</h3>
        <div><?= Html::a('Контакты', ['site/show', 'id' => 52]) ?></div>
        <div><?= Html::a('Режим и график работы', ['site/show', 'id' => 17]) ?></div>
    </div>
    
    <div class="col-sm-2">
        <h3>Пациентам</h3>
        <div><?= Html::a('Баннеры', ['site/banners']) ?></div>
        <div><?= Html::a('Медосмотры', ['site/show', 'id' => 309]) ?></div>
        <div><?= Html::a('Порядок подготовки к диагностическим исследованиям', ['site/show', 'id' => 595]) ?></div>
    </div>
    
    <div class="col-sm-2">
        <h3>Социальные сети</h3>
        <div id="footerSocial">
            <?php $height = 30; ?>
            <?= Html::a(Html::img('@web/images/icons/social/vk.svg', ['height' => $height]), 'https://vk.com/id433055831', ['title' => 'ВКонтакте', 'style' => 'margin-right: 5px;']) ?>
            <?= Html::a(Html::img('@web/images/icons/social/odnoklassniki.svg', ['height' => $height]), 'https://ok.ru/profile/571730537307', ['title' => 'Одноклассники', 'style' => 'margin-right: 5px;']) ?>
            <?= Html::a(Html::img('@web/images/icons/social/facebook.svg', ['height' => $height]), 'https://www.facebook.com/БУ-Няганская-городская-поликлиника-2189851657908954', ['title' => 'Facebook', 'style' => 'margin-right: 5px;']) ?>
            <?= Html::a(Html::img('@web/images/icons/social/twitter.svg', ['height' => $height]), 'https://twitter.com/profilngp1', ['title' => 'Twitter']) ?>
        </div>
    </div>
    
    <div class="col-sm-3">
        <h3>Важная информация</h3>
        <div>
            Телефон единой службы спасения:
            <b>112</b>
        </div>
        <div>
            Контакт-центр: <b>8-800-100-86-03</b>
        </div>
        <div>
            e-mail: <?= Html::mailto('priem@nyagangp.ru') ?>
        </div>
        <div>
            Центр лекарственного мониторинга:<br><b>8(3462)355-461, 355-484</b>
        </div>
    </div>
    
</footer>