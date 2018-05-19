<?php
    use yii\helpers\Html;
?>

<div>
    <p class="text-center">Уважаемый(ая) <?= $auth->fio ?></p>
    <p>Вами было подано обращение на сайте Няганской городской поликлиники.</p>
    
    <b>Дата обращения: </b><?= Yii::$app->formatter->asDate($request->request_created_at, 'dd.MM.yyyy') ?><br>
    <b>Кому: </b><?= $request->requestAuth->fio ?><br>
    <b>Текст: </b><?= Html::encode($request->request_text) ?><br>
    
    <br><br><br>
    
    <p><i>Если Вы получили данное письмо по ошибке, пожалуйста просто удалите его.</i></p>
</div>