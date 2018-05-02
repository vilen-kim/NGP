<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->caption;
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['pages/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::a('Показать', Url::to(['site/show', 'id' => $model->id]), [
    'class' => 'btn btn-default changeBack',
    'style' => 'margin-bottom: 20px;'
]) ?>

<?= Html::a('Изменить', Url::to(['pages/update', 'id' => $model->id]), [
    'class' => 'btn btn-default changeBack',
    'style' => 'margin: 0px 0px 20px 20px;'
]) ?>

<?= Html::a('Удалить', Url::to(['pages/delete', 'id' => $model->id]), [
    'class' => 'btn btn-default changeback',
    'style' => 'margin: 0px 0px 20px 20px;',
    'data' => [
        'confirm' => 'Вы уверены?',
        'method' => 'post',
    ],
]) ?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'caption',
                'categoryCaption',
                'created_at:date',
                'updated_at:date',
                'fio',
            ],
        ]) ?>
    </div>
</div>

<div class="border">
    <?= $model->purified_text ?>
</div>

</div>
