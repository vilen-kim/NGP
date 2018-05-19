<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;

Modal::begin([
    'id' => 'modalResend',
    'header' => "<h4>На кого перенаправляем</h4>",
    'size' => Modal::SIZE_DEFAULT,
    'clientOptions' => [
        'show' => false,
    ],
]);
?>

<p><i>Укажите должностное лицо, на которое Вы хотите перенаправить данное обращение</i></p>

<?php
    echo Html::beginForm(['request/resend']);
        echo Html::dropDownList('auth_id', null, $executiveArray);
        echo Html::hiddenInput('request_id', $id);
        echo Html::submitButton('Отправить', ['class' => 'btn btn-default changeBack pull-right']);
    echo Html::endForm();

Modal::end();
