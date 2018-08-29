<?php

use yii\helpers\Html;

app\assets\SiteAsset::register($this);
$this->title = 'Няганская городская поликлиника';
?>
<div class="site-index row">

    <div class="jumbotron col-md-5" style='padding: 0px;'>
        <?= Html::img($news->image, ['id' => 'image', 'width' => '100%']) ?>
    </div>
    
    <div class="col-md-6 col-md-offset-1">
        <div class="largeBold" id="header"><?= Html::a($news->caption, ['site/show', 'id' => $news->id]) ?></div>
        <div class="mediumNormal" id="text"><?= $news->text ?></div>
        <div id="over"></div>
    </div>
    
    <div class="col-md-12 text-center" id="circles">
        <?php
            $height = 20;
            $selectImage = Html::img('@web/images/select_circle.svg', ['height' => $height]);
            $unselectImage = Html::img('@web/images/unselect_circle.svg', ['height' => $height]);
            echo Html::a($selectImage, '');
            for ($i = 0; $i < 4; $i++){
                echo Html::a($unselectImage, '');
            }
        ?>
    </div>

</div>

<?php
    $this->registerCss('
        #image {
            border-radius: 1px;
        }
        #header {
            margin-bottom: 10px;
            letter-spacing: 2px;
            line-height: 1.3;
        }
        #text {
            position: absolute;
            overflow: hidden;
            z-index: 1;
        }
        #over {
            position: absolute;
            background: linear-gradient(to bottom, transparent, transparent, transparent, white);
            z-index: 2;
        }
        #circles img {
            margin-right: 10px;
            margin-top: -10px;
        }
    ');
    
    $this->registerJs('
        width = $("#text").width();
        bottom = $("#image").offset().top + $("#image").height();
        height = bottom - $("#text").offset().top;
        $("#over").width(width);
        $("#text").height(height);
        $("#over").height(height);
    ');