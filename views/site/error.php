<?php
    use yii\helpers\Html;
    app\assets\ErrorAsset::register($this);
    $this->title = $name;
    $this->params['breadcrumbs'][] = $this->title;
?>

<div id="site-error" class="container">
    
    <h1><?= $this->title ?></h1>

    <div class="alert alert-danger">
        <h3><?= nl2br(Html::encode($message)) ?></h3>
    </div>

</div>
