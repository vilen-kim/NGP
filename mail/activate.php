<?php

use yii\helpers\Html;

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/activate', 'token' => $auth->password_reset_token]);
?>
<div>
    <p class="text-center">Уважаемый(ая) <?= $auth->profile->lastname . ' ' . $auth->profile->firstname . ' ' . $auth->profile->middlename ?></p>
    <p>Для активации Вашей учетной записи необходимо перейти по ссылке: <?= Html::a('активация', $activateLink) ?>.</p>
    <p>
        Должен произойти переход на страницу сайта. Если этого не происходит, Вы можете скопировать адрес<br>
        <u><b><?= $activateLink ?></b></u>,<br>
        вставить его в адресную строку браузера и нажать кнопку "Перейти" либо нажать клавишу <kbd>Enter</kbd>.
    </p>
</div>