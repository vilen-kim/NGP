<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div>
    <?php
    echo Html::a('Создать страницу', Url::to(['pages/create']), ['class' => 'btn btn-default changeBack', 'style' => 'margin-bottom: 20px;']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'contentOptions' => [
                'style' => 'white-space: normal',
            ],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'caption',
            'categoryCaption',
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width: 70px;'],
            ],
        ],
    ]);
    ?>
</div>
