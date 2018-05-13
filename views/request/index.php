<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\RequestUser;

$this->title = 'Обращения';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div>
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'request_auth_id',
                'content' => function ($model, $key, $index, $column) {
                    return Html::a($model->requestAuth->fio . ' - ' . $model->requestAuth->executive->position, ['auth/view', 'id' => $model->requestAuth->id]);
                },
            ],
            [
                'attribute' => 'request_text',
                'content' => function ($model, $key, $index, $column) {
                    $maxLength = 100;
                    $safe = Html::encode($model->request_text);
                    $text = mb_substr($safe, 0, $maxLength);
                    if (mb_strlen($safe) > $maxLength){
                        $text .= '...';
                    }
                    return $text;
                },
            ],
            [
                'label' => 'Авторы обращения',
                'content' => function ($model, $key, $index, $column) {
                    $text = null;
                    foreach ($model->requestUsers as $user){
                        $text .= Html::a($user->auth->fio, ['auth/view', 'id' => $user->auth->id]);
                        if ($user->active == RequestUser::STATUS_INACTIVE){
                            $text .= ' (-)';
                        }
                        $text .= '<br>';
                    }
                    return $text;
                },
            ],
            'request_created_at:date',
            'answer_created_at:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width: 30px;'],
                'template' => '{view}',
            ],
        ],
    ]);
    ?>
</div>
