<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\RequestUser;
use app\models\RequestExecutive;

app\assets\KabinetAsset::register($this);


$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="row kabinet-index">
    <div class="col-md-3">
        <p><?= Html::a('Создать обращение', ['request/write'], ['class' => 'btn btn-default changeBack']) ?></p>
        <?php
            if ($haveRequest) {
                echo '<p>';
                $text = "Мне обращения <span class='badge'>$countUnanswered</span>";
                echo Html::a($text, ['request/have-request'], ['class' => 'btn btn-default changeBack']);
                echo '</p>';
            }
        ?>
        <p><?= Html::a('Мой профиль', ['auth/view', 'id' => Yii::$app->user->id], ['class' => 'btn btn-default changeBack']) ?></p>
    </div>
    <div class="col-md-9">
        <h4 class="text-center"><b>Мои обращения:</b></h4>
        <?php
        if (!is_array($model)){
            echo 'У Вас пока нет поданных обращений.';
        }
        $num = 1;
        foreach ($model as $req) {
            $status = null;
            $actions = null;
            if ($req->active == RequestUser::STATUS_INACTIVE){
                $status = '<span class="text-default">Ожидает активации...</span>';
                $actions = Html::a('<span class="glyphicon glyphicon-ok"></span>', ['request/active', 'id' => $req->request_id], ['title' => 'Активировать', 'class' => 'text-success']);
                $actions .= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['request/delete', 'id' => $req->request_id], ['title' => 'Удалить', 'style' => 'margin-left: 10px;', 'class' => 'text-danger']);
            } else if (!$req->request->answer_text){
                $status = '<span class="text-info">Ожидает ответа...</span>';
                $actions .= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['request/view', 'id' => $req->request_id], ['title' => 'Посмотреть']);
            } else if ($req->request->answer_text){
                $status = '<span class="text-success">Завершено.</span>';
                $actions .= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['request/view', 'id' => $req->request_id], ['title' => 'Посмотреть']);
            }
            echo DetailView::widget([
                'model' => $req,
                'attributes' => [
                    [
                        'label' => '№ п/п',
                        'value' => $num++,
                    ],
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
                        'value' => mb_substr($req->request->request_text, 0, 300) . '...',
                    ],
                    [
                        'label' => 'Статус обращения',
                        'value' => $status,
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Действие',
                        'value' => $actions,
                        'format' => 'raw',
                    ],
                ],
            ]);
        }
        ?>
    </div>
</div>
