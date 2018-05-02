<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    $this->title = $model->caption;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="site-show container">
    <?php
    
        echo $model->purified_text;
        
        if (!Yii::$app->user->isGuest){
            echo Html::a('Редактировать', Url::to(['pages/update', 'id' => $model->id]), ['class' => 'btn btn-warning scale', 'style' => 'margin: 10px;']);
        }
    ?>
</div>
