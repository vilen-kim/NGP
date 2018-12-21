<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RegionDoctor */

$this->title = 'Create Region Doctor';
$this->params['breadcrumbs'][] = ['label' => 'Region Doctors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-doctor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
