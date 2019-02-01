<?php
use yii\helpers\Html;
$this->title = 'Баннеры';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">

    <?php
        if (!Yii::$app->mobileDetect->isMobile()){
        echo Html::beginTag('div', ['class' => 'banners']);
        echo Html::beginTag('div', ['class' => 'row', 'style' => 'margin-bottom: 20px']);
        for ($i = 0; $i < count($banners); $i++){
            $banner = $banners[$i];
            $img = Html::img($banner->image, [
                    'class' => 'scale',
                    'style' => 'box-shadow: 1px 1px 2px gray',
                    'width' => '100%',
                    'alt' => $banner->tag,
            ]);
            $url = $banner->url;
            echo Html::tag('div', Html::a($img, $url), ['class' => 'col-sm-2']);
            if (($i+1) % 6 == 0) {
                echo Html::endTag('div');
                echo Html::beginTag('div', ['class' => 'row', 'style' => 'margin-bottom: 20px']);
            }
        }
        echo Html::endTag('div');
        echo Html::endTag('div');
        } else {
            echo Html::tag('h2', 'Баннеры', ['align' => 'center']);
            for ($i = 0; $i < count($banners); $i++){
                $banner = $banners[$i];
                $img = Html::img($banner->image, ['style' => 'width: 200px; border: 1px solid gray']);
                $url = $banner->url;
                echo Html::tag('div', Html::a($img, $url), ['style' => 'margin-bottom: 10px; text-align: center']);
            }
        }
    ?>

</div>