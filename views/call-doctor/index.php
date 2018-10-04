<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    app\assets\CallDoctorAsset::register($this);
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
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => function ($model, $key, $index, $column){
                        if ($model->closed){
                            return ['style' => 'background: lightgreen;'];
                        } else {
                            return [];
                        }
                    }
                ],
                [
                    'label' => 'Дата заявки',
                    'attribute' => 'dateRequest',
                    'format' => 'date',
                    'headerOptions' => ['style' => 'width: 110px;'],
                ],
                'patient:raw:Пациент',
                [
                    'label' => 'Текст заявки',
                    'attribute' => 'text',
                    'headerOptions' => ['style' => 'width: 30%;'],
                ],
                'registrator:raw:Закрытие заявки',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Действия',
                    'template' => '{working} {comment}',
                    'buttons' => [
                        'working' => function ($url, $model, $key) {
                            $icon = '<span class="glyphicon glyphicon-ok"></span>';
                            $url = ['call-doctor/working', 'id' => $model->id];
                            return $model->closed ? '' : Html::a($icon, $url, ['title' => 'Закрыть заявку']);
                        },
                        'comment' => function ($url, $model, $key) {
                            $icon = '<span class="glyphicon glyphicon-pencil"></span>';
                            return Html::a($icon, '', ['title' => 'Добавить комментарий', 'class' => 'getComment', 'data-id' => $model->id]);
                        },
                    ],
                ],
            ],
        ]);
    ?>
</div>
