<?php
use yii\helpers\Html;

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/activate', 'token' => $auth->password_reset_token]);
?>
<div>
    <p>Здравствуйте.<br>Перейдите по следующей ссылке для активации вашей учетной записи:</p>
    <p><?= Html::a('Активировать', $activateLink) ?></p>
</div>