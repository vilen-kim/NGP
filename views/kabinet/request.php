<?php
use yii\helpers\Html;
use yii\grid\GridView;
app\assets\KabinetAsset::register($this);
$this->title = 'Работа с обращениями';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <?= Html::a('Создать обращение', ['site/request'], [
        'class' => 'btn btn-success',
        'style' => 'margin-bottom: 10px; margin-right: 10px; padding: 16px 12px;'
    ]) ?>
    <?= Html::a('Ответы на обращения, затрагивающие<br>интересы неопределенного круга лиц', ['site/share'], ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 10px']) ?>
    
    <div align="center" style="font-size: large; margin-top: 20px;">
        <?php
        if ($isExecutive) {
            $height = '30px';
            $img = Html::img("@web/images/icons/kabinet/$switch.svg", ['height' => $height]);
            $link = Html::a($img, ['kabinet/request', 'type' => $type + 1]);
            echo "Исходящие $link Входящие";
        }
        ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
  ]) ?>
</div>

<div id="forModal"></div>