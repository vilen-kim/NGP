<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\DetailView;
    $this->title = $model->caption;
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['pages/index']];
?>

<div class="container">

    <?= Html::a('Показать', Url::to(['site/show', 'id' => $model->id]), [
        'class' => 'btn btn-008080',
        'style' => 'margin-bottom: 20px;'
    ]) ?>

    <?= Html::a('Изменить', Url::to(['pages/update', 'id' => $model->id]), [
        'class' => 'btn btn-warning',
        'style' => 'margin: 0px 0px 20px 20px;'
    ]) ?>

    <?= Html::a('Удалить', Url::to(['pages/delete', 'id' => $model->id]), [
        'class' => 'btn btn-danger',
        'style' => 'margin: 0px 0px 20px 20px;',
        'data' => [
            'confirm' => 'Вы уверены?',
            'method' => 'post',
        ],
    ]) ?>

    <p>Категория: <?= $model->categoryCaption ?></p>
    <p>Создано: <?= Yii::$app->formatter->asDate($model->created_at) ?></p>
    <p>Изменено: <?= Yii::$app->formatter->asDate($model->updated_at) ?></p>
    <p>Редактор: <?= $model->fio ?></p>

    <h1 style="margin-top: 40px;"><?= $this->title ?></h1>

    <?= $model->purified_text ?>

</div>