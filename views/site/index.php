<?php

use yii\helpers\Html;

app\assets\SiteAsset::register($this);
$this->title = 'Няганская городская поликлиника';
?>
<div class="site-index row">

    <div class="jumbotron col-md-5" style='padding: 0px;'>
        <?= Html::img($news->image, ['width' => '100%', 'style' => 'border-radius: 4px;']) ?>
    </div>
    <div class="col-md-5 col-md-offset-1" style="margin-top: 20px;">
        <div class="largeBold" style="margin-bottom: 20px;"><?= $news->caption ?></div>
        <div class="mediumGray" style="margin-bottom: 10px;"><?= $news->text ?>...</div>
        <?= Html::a('Читать далее.', ['site/show', 'id' => $news->id]) ?>
    </div>

</div>