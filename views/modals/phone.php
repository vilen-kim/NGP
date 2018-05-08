<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;

Modal::begin([
    'id' => 'modalPhone',
    'header' => "<h4>Справочник телефонов</h4>",
    'size' => Modal::SIZE_DEFAULT,
    'clientOptions' => [
        'show' => false,
    ],
]);
?>

<p><i>Получить необходимую консультацию специалистов лечебно-профилактического учреждения можно <b>по внутреннему телефону</b>.
        Для этого необходимо набрать номер <b>5-45-30</b>, а затем цифры, соответствующие внутреннему номеру телефона сотрудника.</i></p><br>

<p><b>204</b> - Приемная</p>
<p><b>141, 142, 143, 144</b> - Регистратура</p>
<p><b>101</b> - Вызов врача на дом</p>
<p><b>102</b> - Колл-центр</p>
<p><b>103</b> - Стол справок</p>
<p><b>111</b> - Администратор</p>
<p>
    <?= Html::a('Показать все телефоны', ['site/phone']) ?>
</p>
<?php


Modal::end();