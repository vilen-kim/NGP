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
            'description:text:Роль',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}{link}',
            ],
        ],
    ]);
    ?>
</div>
