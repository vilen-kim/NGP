<?php

use yii\helpers\Html;
use yii\helpers\Url;

app\assets\SiteAsset::register($this);

$this->title = $model->caption;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="site-show container">

    <div class="text-justify">
        <?= $model->purified_text ?>
    </div>

    <?php
    if (!Yii::$app->user->isGuest) {
        echo Html::a('Редактировать', Url::to(['pages/update', 'id' => $model->id]), ['class' => 'btn btn-default changeBack', 'style' => 'margin: 10px;']);
    }
    ?>
</div>
