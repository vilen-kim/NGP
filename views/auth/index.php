<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div>
    <?php
    echo Html::a('Создать пользователя', Url::to(['auth/create']), ['class' => 'btn btn-default changeBack', 'style' => 'margin-bottom: 20px;']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'fio:text:ФИО',
            'email:email',
            'description:text:Роль',
            'created_at:date',
            [
                'attribute' => 'status',
                'content' => function ($model, $key, $index, $column) {
                    if ($model->status == $model::STATUS_ACTIVE) {
                        return 'Активна';
                    } else {
                        return 'Не активна';
                    }
                },
            ],
            [
                'attribute' => 'executive',
                'label' => 'Должностное лицо',
                'content' => function ($model, $key, $index, $column) {
                    if (isset($model->executive)) {
                        return 'Да';
                    }
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
