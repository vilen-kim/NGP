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

<?php
    if (!Yii::$app->mobileDetect->isMobile()){
        $style = 'col-sm-8 col-sm-offset-2';
        $btnStyle = 'margin-right: 10px';
    } else {
        $style = '';
        $btnStyle = 'margin-bottom: 10px';
    }
?>

<div class="container">
    <div class="<?= $style ?>">

        <div style="margin-bottom: 20px; text-align: center;">
            <?= Html::a('Создать элемент меню', ['menu/create'], ['class' => 'btn btn-success', 'style' => $btnStyle]) ?>
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
