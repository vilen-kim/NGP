<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RegionDoctor */

$this->title = 'Update Region Doctor: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Region Doctors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="region-doctor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
