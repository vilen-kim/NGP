<?php
    use yii\helpers\Html;
    app\assets\MenuAsset::register($this);
    $this->title = 'Меню';
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">

    <?php if (!Yii::$app->mobileDetect->isMobile()) { ?>
        <div class="col-md-3" style="border-right: 1px solid lightgray;">
    <?php } else { ?>
            <div class="col-md-3" style="border-bottom: 1px solid lightgray;">
    <?php } ?>
    <?php
        for ($i = 0; $i < count($items); $i++){
            $item = $items[$i];
            $url = ($item['url']) ? $item['url'] : '';
            $link = Html::a($item['label'], $url, ['id' => $i, 'class' => 'menuHeader']);
            echo Html::tag('h3', $link);
        }
    ?>
    </div>

    <div class="col-md-9" id="subMenu">
        <?php if (!Yii::$app->mobileDetect->isMobile()) { ?>
            <h4>Выберите пункт меню слева.</h4>
        <?php } else { ?>
            <h4>Выберите пункт меню сверху.</h4>
        <?php } ?>
    </div>
</div>