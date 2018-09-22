<?php
use yii\helpers\Html;
$this->title = 'Баннеры';
?>

<h1><?= $this->title ?></h1>

<div class="container">

    <?php
        $divRow = false;
        for ($i = 0; $i < count($banners); $i++){
            $banner = $banners[$i];
            $img = Html::img($banner->image, ['class' => 'scale', 'style' => 'box-shadow: 1px 1px 2px gray', 'width' => '100%']);
            $url = $banner->url;
            $content = Html::tag('div', Html::a($img, $url), ['class' => 'col-md-2', 'style' => 'margin-bottom: 20px;']);
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