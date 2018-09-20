<?php
    use yii\helpers\Html;
?>

<div>
    <p class="text-center">Уважаемый(ая) <?= $request->requestAuth->fio ?></p>
    <p>Вам было перенаправлено обращение от <?= $fio ?>.</p>
    
    <b>Дата обращения: </b><?= Yii::$app->formatter->asDate($request->request_created_at, 'dd.MM.yyyy') ?><br>
    <b>Автор(ы): </b>
        <?php
            foreach($request->requestUsers as $users){
                echo $users->auth->fio . '<br>';
            }
        ?>
    <br>
    <b>Текст: </b><?= Html::encode($request->request_text) ?><br>
    
    <br><br><br>
    
    <p><i>Если Вы получили данное письмо по ошибке, пожалуйста просто удалите его.</i></p>
</div>