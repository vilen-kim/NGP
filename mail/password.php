<?php
use yii\helpers\Html;

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/new-password', 'token' => $auth->password_reset_token]);
?>
<div>
    <p>Здравствуйте.<br>Перейдите по следующей ссылке для сброса Вашего пароля и установки нового:</p>
    <p><?= Html::a('Сбросить пароль', $activateLink) ?></p>
</div>