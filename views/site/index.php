<?php
    use yii\helpers\Html;
    app\assets\SiteAsset::register($this);
    $this->title = 'Последние новости';
?>

<div id="site-index" class="container">
    
    <h1 class="title"><?= $this->title ?></h1>
    
    <?php for ($i = 0; $i < count($news); $i++){ ?>
        <div class="col-md-10 col-md-offset-1 row animatedParent animateOnce">
            <div class="col-md-5 animated fadeInLeft">
                <?php
                    if ($i % 2 == 1) {
                        echo Html::img($news[$i]->image);
                    } else {
                        $url = Html::a($news[$i]->caption, ['site/show', 'id' => $news[$i]->id]);
                        echo "<p>$url</p>";
                    }
                ?>
            </div>
            <div class="col-md-5 col-md-offset-2 animated fadeInRight">
                <?php
                    if ($i % 2 == 1) {
                        $url = Html::a($news[$i]->caption, ['site/show', 'id' => $news[$i]->id]);
                        echo "<p>$url</p>";
                    } else {
                        echo Html::img($news[$i]->image);
                    }
                ?>
            </div>
        </div>
    <?php } ?>
    
</div>

<?php
    $this->registerCss('
        #site-index > div.row {
            margin-bottom: 100px;
        }
        #site-index > div.row img {
            width: 100%;
        }
        #site-index > div.row p {
            font-size: x-large;
            font-weight: bold;
            margin-top: 40px;
        }
    ');