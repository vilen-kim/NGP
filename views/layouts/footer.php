<?php
    use yii\helpers\Html;
?>

<footer class="rows">
    <div class="col-md-3">
        <div style="font-size: small">Бюджетное учреждение Ханты-Мансийского автономного округа - Югры "Няганская городская поликлиника"</div>
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3">
        <?= Html::a(Html::img('@web/images/vk.svg', ['class' => 'moveUp']), 'https://vk.com/id433055831', ['title' => 'ВКонтакте']) ?>
        <?= Html::a(Html::img('@web/images/odnoklassniki.svg', ['class' => 'moveUp']), 'https://ok.ru/profile/571730537307', ['title' => 'Одноклассники']) ?>
        <?= Html::a(Html::img('@web/images/facebook.svg', ['class' => 'moveUp']), 'https://www.facebook.com/БУ-Няганская-городская-поликлиника-2189851657908954', ['title' => 'Facebook']) ?>
        <?= Html::a(Html::img('@web/images/twitter.svg', ['class' => 'moveUp']), 'https://twitter.com/profilngp1', ['title' => 'Twitter']) ?>
    </div>
    <div class="col-md-3">
        <div style="font-size: small">
            Телефон единой службы спасения:
            <span style="color: red; font-size: medium; font-weight: bold"><i><u>112</u></i></span>
        </div>
        <div style="font-size: small">
            Контакт-центр: <span style="font-size: medium; font-weight: bold">8-800-100-86-03</span>
        </div>
    </div>
</footer>