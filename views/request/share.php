<?php

use yii\jui\Accordion;
use yii\widgets\LinkPager;
use yii\jui\DatePicker;
use yii\helpers\Html;

app\assets\RequestAsset::register($this);

$this->title = 'Ответы на обращения, затрагивающие интересы неопределенного круга лиц';
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="request-share">
    <p><i>Для просмотра ответа необходимо щелкнуть по тексту обращения.</i></p>
    
    <p><i>Вы можете посмотреть обращения, поданные на определенную дату:</i><br>
    <?php
        echo DatePicker::widget([
            'name'  => 'date',
            'language' => 'ru',
            'dateFormat' => 'dd.MM.yyyy',
        ]);
        echo Html::a('Применить', '', ['class' => 'btn btn-default changeBack', 'id' => 'dateFilter']);
    ?>
    </p>
    
    <?= Accordion::widget([
        'items' => $array,
        'clientOptions' => [
            'collapsible' => true,
            'heightStyle' => 'content',
            'active' => false,
            'icons' => false,
        ],
        'headerOptions' => [
            'style' => [
                'background' => 'none',
                'border' => 'none',
                'margin-top' => '20px',
            ],
        ],
        'itemOptions' => [
            'style' => [
                'background' => 'lightgray',
                'border' => 'none',
                'padding' => '10px 50px',
            ],
        ],
    ]) ?>
    
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]) ?>
        
    
</div>