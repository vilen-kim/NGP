<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RegionAddress */

$this->title = 'Create Region Address';
$this->params['breadcrumbs'][] = ['label' => 'Region Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
