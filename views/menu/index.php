<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\Sortable;
use yii\web\JsExpression;

app\assets\MenuAsset::register($this);

$this->title = 'Меню';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<?= Html::a('Создать элемент меню', Url::to(['menu/create']), ['class' => 'btn btn-default changeBack', 'style' => 'margin-bottom: 20px;']) . '<br>' ?>
<?= Html::a('Сохранить меню', '', ['id' => 'menuSave' , 'class' => 'btn btn-default changeBack', 'style' => 'margin-bottom: 20px;']) . '<br>' ?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">

        <?php
        $cnt = 0;
        $menuItems = [];
        foreach ($array as $arr) {
            if (!is_array($arr)) {
                $cnt++;
                $menuItems[$cnt] = $arr;
            } else {
                $menuSubitems = [];
                foreach ($arr as $sub) {
                    $menuSubitems[] = $sub;
                }
                $menuItems[$cnt] .= Sortable::widget([
                    'items' => $menuSubitems,
                    'options' => [
                        'class' => 'subMenu',
                    ],
                    'itemOptions' => [
                        'tag' => 'div',
                        'style' => [
                            'padding' => '5px',
                            'font-weight' => 'normal',
                            'font-size' => 'medium',
                            'margin-top' => '5px',
                        ],
                    ],
                    'clientOptions' => [
                        'cursor' => 'move',
                        'placeholder' => 'ui-state-highlight',
                        'connectWith' => '.subMenu',
                    ],
                ]);
            }
        }
        echo Sortable::widget([
            'items' => $menuItems,
            'itemOptions' => [
                'tag' => 'h4',
                'style' => [
                    'border' => '1px solid lightgray',
                    'padding' => '10px',
                ],
            ],
            'clientOptions' => [
                'cursor' => 'move',
                'placeholder' => 'ui-state-highlight',
            ],
        ]);
        ?>

    </div>
</div>
