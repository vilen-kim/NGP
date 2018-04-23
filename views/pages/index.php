<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = $tt['title'];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="pages-index">
    <?php
    echo Html::a('Создать', Url::to(['pages/create', 'category_id' => $category_id]), ['class' => 'btn btn-success scale', 'style' => 'margin-bottom: 20px;']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'caption',
                'content' => function ($data){
                    return Html::a($data->caption, ['pages/view', 'id' => $data->id]);
                },
            ],
            'created_at:date',
            'updated_at:date',
            'username',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}{link}',
            ],
        ],
    ]);
    ?>
</div>
