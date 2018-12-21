<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RegionLink */

$this->title = 'Create Region Link';
$this->params['breadcrumbs'][] = ['label' => 'Region Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
