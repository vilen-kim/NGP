<?php
    use yii\helpers\Html;
?>

<div>
    <p class="text-center">Уважаемый(ая) <?= $auth->fio ?></p>
    <p>Вам был отправлен ответ на Ваше обращение.</p>
    
    <b>Дата обращения: </b><?= Yii::$app->formatter->asDate($request->request_created_at, 'dd.MM.yyyy') ?><br>
    <b>Автор(ы): </b>
        <?php
            foreach($request->requestUsers as $user){
                echo $user->auth->fio;
                echo ($user->active) ? ' (активировано)<br>' : ' (не активировано)<br>';
            }
        ?>
    <b>Текст обращения: </b><?= Html::encode($request->request_text) ?><br>
    
    <br>
    
    <b>Дата ответа: </b><?= Yii::$app->formatter->asDate($request->answer_created_at, 'dd.MM.yyyy') ?><br>
    <b>Автор ответа: </b><?= $request->answerAuth->fio ?><br>
    <b>Текст ответа: </b><?= Html::encode($request->answer_text) ?>
    
    <br><br><br>
    
    <p><i>Если Вы получили данное письмо по ошибке, пожалуйста просто удалите его.</i></p>
</div>