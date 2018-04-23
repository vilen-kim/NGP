<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="admin-users">
    <?php
    echo Html::a('Создать пользователя', Url::to(['auth/create']), ['class' => 'btn btn-success scale', 'style' => 'margin-bottom: 20px;']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'description:text:Роль',
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{activate} {update} {delete}',
                'buttons' => [
                    'activate' => function ($url, $model, $key) {
                        if ($model->status == $model::STATUS_INACTIVE){
                            return Html::a('<span class="glyphicon glyphicon-check"></span>', ['auth/activate', 'id' => $model->id], [
                                'title' => 'Активировать',
                            ]);
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-unchecked"></span>', ['auth/deactivate', 'id' => $model->id], [
                                'title' => 'Деактивировать',
                            ]);
                        }
                    },
                ]
            ],
        ],
    ]);
    ?>
</div>
