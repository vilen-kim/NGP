<?php

use yii\jui\Accordion;

app\assets\RequestAsset::register($this);

$this->title = 'Ответы на обращения, затрагивающие интересы неопределенного круга лиц';
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="request-share">
    <p><i>Для просмотра ответа необходимо щелкнуть по тексту обращения.<br>
    Справа от текста обращения имеется ссылка, позволяющая сохранить ответ
    на него в формате *.pdf.</i></p>
    
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
    ]); ?>
        
    
</div>