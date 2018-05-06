<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Адресаты обращений';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div>
    <?php
    echo Html::a('Создать адресата', Url::to(['request/create']), ['class' => 'btn btn-default changeBack', 'style' => 'margin-bottom: 20px;']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'fio:text:ФИО',
            'email:email',
            'position',
            'organization',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
