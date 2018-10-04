<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    $this->title = 'Заявки на вызов доктора';
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'fio',
                'phone',
                'address',
                'email:email',
                'text',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    ?>
</div>
