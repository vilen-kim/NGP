<?php

use yii\helpers\Html;

app\assets\SiteAsset::register($this);
$this->title = 'Няганская городская поликлиника';
?>
<div class="site-index row">

    <div class="jumbotron col-md-5" style='padding: 0px;'>
        <?= Html::img($news->image, ['width' => '100%', 'style' => 'border-radius: 1px']) ?>
    </div>
    <div class="col-md-5 col-md-offset-1" style="margin-top: 20px;">
        <div class="largeBold"><?= Html::a($news->caption, ['site/show', 'id' => $news->id]) ?></div>
        <div class="mediumGray"><?= $news->text ?></div>
        <div id='over'></div>
    </div>
    <div class="col-md-1">
        <?php $height = 10 ?>
        <div><?= Html::a(Html::img('@web/images/select_circle.svg', ['height' => $height, 'style' => 'margin-bottom: 10px; margin-top: 80px;']), '') ?></div>
        <div><?= Html::a(Html::img('@web/images/unselect_circle.svg', ['height' => $height, 'style' => 'margin-bottom: 10px;']), '') ?></div>
        <div><?= Html::a(Html::img('@web/images/unselect_circle.svg', ['height' => $height, 'style' => 'margin-bottom: 10px;']), '') ?></div>
        <div><?= Html::a(Html::img('@web/images/unselect_circle.svg', ['height' => $height, 'style' => 'margin-bottom: 10px;']), '') ?></div>
        <div><?= Html::a(Html::img('@web/images/unselect_circle.svg', ['height' => $height, 'style' => 'margin-bottom: 10px;']), '') ?></div>
    </div>

</div>

<?php
    $this->registerCss('
        div.largeBold {
            margin-bottom: 20px;
            letter-spacing: 2px;
            line-height: 1.3;
        }
        div.largeBold a {
            color: rgb(51,51,51);
        }
        div.mediumGray {
            position: absolute;
            height: 150px;
            overflow: hidden;
            z-index: 1;
        }
        div#over {
            position: absolute;
            height: 150px;
            background: linear-gradient(to bottom, transparent, transparent, transparent, white);
            z-index: 2;
        }
    ');
    
    $this->registerJs('
        $("div#over").width($("div.mediumGray").width());
    ');