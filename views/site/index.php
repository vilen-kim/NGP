<?php
    use yii\helpers\Html;
    app\assets\SiteAsset::register($this);
    $this->title = 'Няганская городская поликлиника';
?>

<div class="site-index row">

    <div class="jumbotron col-md-5" style='padding: 0px;'>
        <?= Html::img($news->image, ['width' => '100%', 'id' => 'newsImage']) ?>
    </div>
    
    <div class="col-md-6 col-md-offset-1">
        <div class="largeBold" id="newsHeader">
            <?= Html::a($news->caption, ['site/show', 'id' => $news->id]) ?>
        </div>
        <div class="mediumNormal" id="newsText">
            <?= $news->text ?>
        </div>
    </div>
    
    <div class="col-md-12 text-center" id="newsNavigation">
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
        #backImage {
            background-image: url("images/backgrounds/siteIndex.jpg");
            background-size: cover;
            padding: 0px;
        }
        #backImageOver {
            background: rgba(255, 255, 255, 0.8);
            
        }
        #newsHeader {
            margin-bottom: 10px;
            letter-spacing: 2px;
            line-height: 1.3;
        }
        #newsText {
            position: absolute;
            overflow: hidden;
            z-index: 1;
        }
        #newsNavigation img {
            margin-right: 10px;
            margin-top: -10px;
        }
    ');
    
    $this->registerJs('
        width = $("#newsText").width();
        bottom = $("#newsImage").offset().top + $("#newsImage").height();
        height = bottom - $("#newsText").offset().top;
        $("#newsText").height(height);
    ');