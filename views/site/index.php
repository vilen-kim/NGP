<?php
use yii\helpers\Html;
app\assets\SiteAsset::register($this);
$this->title = 'Последние новости';
?>

<?php if (!Yii::$app->session->get('eye')){ ?>
    <div class = "parallax-window" data-parallax = "scroll" data-image-src = "/images/backgrounds/parallax.jpg" data-natural-width = 1920 data-natural-height = 1080 data-speed = 0.2>
    <div id="parallaxWhite">
<?php } ?>
        
        <div id="site-index" class="container">

            <h1><?= $this->title ?></h1>

            <?php for ($i = 0; $i < count($news); $i++){ ?>
                <div class="col-md-10 col-md-offset-1 row animatedParent animateOnce">

                    <div class="col-md-5 animated fadeInLeft">
                        <?php
                        if ($i % 2 == 1) {
                            echo Html::img($news[$i]->image);
                        } else {
                            $url = Html::a($news[$i]->caption, ['site/show', 'id' => $news[$i]->id]);
                            echo "<h2>$url</h2>";
                        }
                        ?>
                    </div>

                    <div class="col-md-5 col-md-offset-2 animated fadeInRight">
                        <?php
                        if ($i % 2 == 1) {
                            $url = Html::a($news[$i]->caption, ['site/show', 'id' => $news[$i]->id]);
                            echo "<h2>$url</h2>";
                        } else {
                            echo Html::img($news[$i]->image);
                        }
                        ?>
                    </div>

                </div>
            <?php } ?>

            <?php
                $divRow = false;
                for ($i = 0; $i < count($banners); $i++){
                    $banner = $banners[$i];
                    $img = Html::img($banner->image, ['class' => 'scale', 'style' => 'box-shadow: 1px 1px 2px gray']);
                    $url = $banner->url;
                    $content = Html::tag('div', Html::a($img, $url), ['class' => 'col-md-2']);
                    if ($i % 6 == 0){
                        if ($divRow)
                            echo Html::endTag('div');
                        echo Html::beginTag('div', ['class' => ['col-md-12', 'row', 'banners']]);
                        $divRow = true;
                    }
                    echo $content;
                }
                echo Html::endTag('div');
            ?>

        </div>
        
<?php if (!Yii::$app->session->get('eye')){ ?>
    </div>
    </div>
<?php } ?>