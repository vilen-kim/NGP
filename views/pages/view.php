<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->caption;
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => $type, 'url' => ['pages/index', 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="pages-view">
    <?php
    echo Html::a('Показать', Url::to(['site/show', 'id' => $model->id]), [
        'class' => 'btn btn-success scale',
        'style' => 'margin-bottom: 20px;'
    ]);
    
    echo Html::a('Изменить', Url::to(['pages/update', 'id' => $model->id]), [
        'class' => 'btn btn-primary scale',
        'style' => 'margin: 0px 0px 20px 20px;'
    ]);

    echo Html::a('Удалить', Url::to(['pages/delete', 'id' => $model->id]), [
        'class' => 'btn btn-danger',
        'style' => 'margin: 0px 0px 20px 20px;',
        'data' => [
            'confirm' => 'Вы уверены?',
            'method' => 'post',
        ],
    ]);

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'caption',
            'category.caption',
            'created_at:date',
            'updated_at:date',
            'auth.username',
        ],
    ]);
        
    echo \yii\helpers\HtmlPurifier::process($model->text);
 
    ?>
</div>
