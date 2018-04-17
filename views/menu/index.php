<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Меню';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="menu-index">
    <?= Html::a('Создать элемент меню', Url::to(['menu/create']), ['class' => 'btn btn-success scale', 'style' => 'margin-bottom: 20px;']). '<br>' ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'caption',
            'parent_id',
            'page.caption',
            'anchor',
            'position',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}{link}',
            ],
        ],
    ]) ?>
</div>
