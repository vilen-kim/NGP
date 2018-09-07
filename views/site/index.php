<?php
    use yii\helpers\Html;
    app\assets\SiteAsset::register($this);
    $this->title = 'Няганская городская поликлиника';
?>

<div class="row">

    <div class="jumbotron col-md-5" style='padding: 0px;'>
        <?php
            foreach($news as $new){
                echo Html::img($new->image, ['width' => '100%']);
            }
        ?>
    </div>
    
    <div class="col-md-6 col-md-offset-1">
        <div id="newsHeader">
        </div>
    </div>
    
    <div class="col-md-12 text-center" id="newsNavigation">
        <?php
            $height = 20;
            $selectImage = Html::img('@web/images/icons/select_circle.svg', ['height' => $height]);
            $unselectImage = Html::img('@web/images/icons/unselect_circle.svg', ['height' => $height]);
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
        }
        .jumbotron > img {
            position: absolute;
            top: 0px;
        }
        #newsHeader {
            margin-top: 100px;
            letter-spacing: 2px;
            line-height: 1.3;
        }
        #newsNavigation img {
            margin-right: 10px;
            margin-top: -10px;
        }
    ');