<?php

use yii\helpers\Html;

app\assets\RequestAsset::register($this);

$this->title = 'Ответы на обращения, затрагивающие интересы неопределенного круга лиц';
?>

<div class="request-share">
    <?php foreach($model as $req){ ?>
        <div class="row">
            <div class="col-md-10">
                <p class="small" style="font-weight: bold;"><i>Вопрос от <?= Yii::$app->formatter->asDate($req->request_created_at) ?></i></p>
                <p class="text-justify"><?= Html::encode($req->request_text) ?></p>
            </div>
            <div class="col-md-10 col-md-offset-2">
                <p class="small" style="font-weight: bold;"><i>Ответ от <?= Yii::$app->formatter->asDate($req->answer_created_at) ?></i></p>
                <p class="text-justify"><?= Html::encode($req->answer_text) ?></p>
            </div>
        </div>
    <?php } ?>
    
</div>