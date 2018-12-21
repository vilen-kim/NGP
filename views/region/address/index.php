<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Region Addresses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-address-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Region Address', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'street_id',
            'house',
            'house_from',
            'house_to',
            //'parity',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
