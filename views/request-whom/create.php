<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RequestWhom */

$this->title = 'Create Request Whom';
$this->params['breadcrumbs'][] = ['label' => 'Request Whoms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-whom-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
