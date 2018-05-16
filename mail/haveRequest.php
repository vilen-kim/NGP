<div>
    <p class="text-center">Уважаемый(ая) <?= $model->requestAuth->fio ?></p>
    <p>Вам было отправлено обращение с сайта Няганской городской поликлиники.</p>
    
    <b>Дата обращения: </b><?= Yii::$app->formatter->asDate($model->request_created_at, 'dd.MM.yyyy') ?><br>
    <b>Автор(ы): </b>
        <?php
            foreach($model->requestUsers as $users){
                echo $users->auth->fio;
                echo ($users->active) ? ' (активировано)<br>' : ' (не активировано)<br>';
            }
        ?>
    <br>
    <b>Текст: </b><?= $model->request_text ?><br>
    
    <br><br><br>
    
    <p><i>Если Вы получили данное письмо по ошибке, пожалуйста просто удалите его.</i></p>
</div>