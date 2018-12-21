<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RegionLink */

$this->title = 'Update Region Link: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Region Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="region-link-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
