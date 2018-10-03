<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    $this->title = 'Пользователи';
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <?php
        echo Html::a('Создать пользователя', ['auth/create'], ['class' => 'btn btn-008080', 'style' => 'margin-bottom: 10px']);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'fio:text:ФИО',
                'email:email',
                'description:text:Роль',
                'created_at:date',
                [
                    'attribute' => 'status',
                    'content' => function ($model, $key, $index, $column) {
                        if ($model->status == $model::STATUS_ACTIVE) {
                            return 'Активна';
                        } else {
                            return 'Не активна';
                        }
                    },
                ],
                [
                    'attribute' => 'executive',
                    'label' => 'Должностное лицо',
                    'content' => function ($model, $key, $index, $column) {
                        if (isset($model->executive)) {
                            return 'Да';
                        }
                    },
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
    ?>
</div>
