<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\RequestUser;

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
        <h4 class="text-center"><b>Обращения:</b></h4>
        <?php
        $num = 1;
        foreach ($model as $req) {
            echo $num++ . DetailView::widget([
                'model' => $req,
                'attributes' => [
                    [
                        'label' => 'Дата обращения',
                        'value' => $req->request->request_created_at,
                        'format' => 'date',
                    ],
                    [
                        'label' => 'Кому',
                        'value' => $req->request->requestAuth->fio . ' - ' . $req->request->requestAuth->executive->position,
                    ],
                    [
                        'label' => 'Текст',
                        'value' => $req->request->request_text,
                    ],
                    [
                        'label' => 'Не активировано',
                        'value' => Html::a('Активировать', ['request/active', 'id' => $req->id]),
                        'format' => 'raw',
                        'visible' => ($req->active == RequestUser::STATUS_INACTIVE) ? true : false,
                    ],
                    [
                        'label' => 'Ответ',
                        'value' => ($req->request->answer_text) ? Html::a('Ответ', ['request/view', 'id' => $req->request->id]) : 'Нет ответа',
                        'format' => 'raw',
                        'visible' => ($req->active == RequestUser::STATUS_ACTIVE) ? true : false,
                    ],
                ],
            ]);
        }
        ?>
    </div>
</div>
