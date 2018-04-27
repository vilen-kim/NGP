<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\helpers\HtmlPurifier;
    $this->title = $model->caption;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="site-show container">
    <?php
    
        echo HtmlPurifier::process($model->text, [
            'Attr.EnableID' => true,
        ]);
        
        if (!Yii::$app->user->isGuest){
            echo Html::a('Редактировать', Url::to(['pages/update', 'id' => $model->id]), ['class' => 'btn btn-warning scale', 'style' => 'margin: 10px;']);
        }
    ?>
</div>
