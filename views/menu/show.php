<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\Sortable;

app\assets\MenuAsset::register($this);

$this->title = 'Меню';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<?= Html::a('Создать элемент меню', Url::to(['menu/create']), ['class' => 'btn btn-default changeBack', 'style' => 'margin-bottom: 20px;']) ?>
<?= Html::a('Сохранить порядок меню', '', ['id' => 'menuSave', 'class' => 'btn btn-default changeBack', 'style' => 'margin: 0px 0px 20px 20px;']) ?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <?= Sortable::widget([
            'items' => $array,
            'itemOptions' => [
                'tag' => 'h4',
                'style' => [
                    'border' => '1px solid lightgray',
                    'font-weight' => 'bold',
                    'padding' => '10px',
                ],
            ],
            'clientOptions' => [
                'cursor' => 'move',
                'placeholder' => 'ui-state-highlight',
            ],
        ]) ?>

    </div>
</div>