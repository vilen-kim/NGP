<?php

use yii\helpers\Html;

app\assets\KabinetAsset::register($this);


$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="row kabinet-index">
    <div class="col-md-3">
        <p><?= Html::a('Создать обращение', ['request/write'], ['class' => 'btn btn-default changeBack']) ?></p>
        <p><?= Html::a('Мой профиль', ['auth/view', 'id' => Yii::$app->user->id], ['class' => 'btn btn-default changeBack']) ?></p>
    </div>
    <div class="col-md-9">
        <div class="text-center">
            <?= Html::radioList('requestType', $type, ['fromMe' => 'Мои обращения', 'toMe' => "Принятые обращения <span class='badge'>$count</span>"], ['encode' => false]) ?>
        </div>
        <div id="requests">
            <?php
                if (!$detailView){
                    echo 'У Вас пока нет обращений.';
                } else {
                    echo $detailView;
                }
            ?>
        </div>
    </div>
</div>
