<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Улицы';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
$this->params['breadcrumbs'][] = ['label' => 'Терапевтические участки', 'url' => ['kabinet/regions']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">

    <?php
        echo Html::a('Добавить улицу', ['region/street-add'], ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px']);

        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'caption',
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width: 70px;'],
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['region/street-update', 'id' => $model->id]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['region/street-delete', 'id' => $model->id]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
