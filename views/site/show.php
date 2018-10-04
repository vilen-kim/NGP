<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	$this->title = $model->caption;
    $this->params['breadcrumbs'][] = $this->title;
    if (Yii::$app->user->can('editor')) {
        $this->title .= ' ' . Html::a(
            '<span class="glyphicon glyphicon-pencil"></span>',
            ['pages/update', 'id' => $model->id],
            ['style' => 'font-size: 0.7em; color: #008080;']);
    }
?>

<h1><?= $this->title ?></h1>

<div class="container">
    
    <div class="text-justify">
        <?= $model->purified_text ?>
    </div>
    
</div>
