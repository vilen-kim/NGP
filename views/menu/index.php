<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\jui\Sortable;
    app\assets\MenuAsset::register($this);
    $this->title = 'Меню';
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-md-8 col-md-offset-2">

        <div style="margin-bottom: 20px; text-align: center;">
            <?= Html::a('Создать элемент меню', ['menu/create'], ['class' => 'btn btn-success', 'style' => 'margin-right: 10px;']) ?>
            <?= Html::a('Сохранить порядок меню', '', ['id' => 'menuSave', 'class' => 'btn btn-primary']) ?>
        </div>


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
