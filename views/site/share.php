<?php
    use yii\jui\Accordion;
    use yii\widgets\LinkPager;
    use yii\jui\DatePicker;
    use yii\helpers\Html;
    app\assets\RequestAsset::register($this);
    $this->title = 'Ответы на обращения, затрагивающие интересы неопределенного круга лиц';
    if (Yii::$app->user->can('user')){
        $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
        $this->params['breadcrumbs'][] = ['label' => 'Работа с обращениями', 'url' => ['kabinet/request']];
    }
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <p><i>Для просмотра ответа необходимо щелкнуть по тексту обращения.</i></p>
    
    <p><i>Вы можете посмотреть обращения, поданные на определенную дату:</i><br><br>
    <?php
        echo DatePicker::widget([
            'name'      => 'date',
            'language'  => 'ru',
            'dateFormat'=> 'dd.MM.yyyy',
        ]);
        echo Html::a('Применить', '', ['class' => 'btn btn-008080', 'id' => 'dateFilter']);
    ?>
    </p>
    
    <?= Accordion::widget([
        'items' => $array,
        'clientOptions' => [
            'collapsible'=> true,
            'heightStyle'=> 'content',
            'active'     => false,
            'icons'      => false,
        ],
        'headerOptions' => [
            'style' => [
                'background'=> 'none',
                'border'    => 'none',
                'margin-top'=> '20px',
            ],
        ],
        'itemOptions' => [
            'style' => [
                'background'=> 'lightgray',
                'border'    => 'none',
                'padding'   => '10px 50px',
            ],
        ],
    ]) ?>
    
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]) ?>
        
    
</div>