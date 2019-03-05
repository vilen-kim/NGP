<?php
    use yii\helpers\Html;
    app\assets\MenuAsset::register($this);
    $this->title = 'Меню';
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">

    <div class="col-md-3" style="border-right: 1px solid lightgray;">
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
        <h4>Выберите пункт меню слева.</h4>
    </div>
</div>