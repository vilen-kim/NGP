<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;

Modal::begin([
    'id' => 'modalResend',
    'header' => "<h2>На кого перенаправляем</h2>",
    'size' => Modal::SIZE_DEFAULT,
    'clientOptions' => [
        'show' => false,
    ],
    'headerOptions' => [
        'style' => [
            'background' => '#008080',
            'color' => 'white',
        ],
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
