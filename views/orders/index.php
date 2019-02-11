<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    app\assets\OrderAsset::register($this);
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Страница приказов', 'url' => ['orders/page']];
    $this->params['breadcrumbs'][] = $title;
?>

<h1><?= $title ?></h1>

<div class="container">
    <?php
        if ($title == 'Приказы') {
            echo Html::a('Архивные приказы', ['orders/index', 'archive' => true],
                ['class' => 'btn btn-danger', 'style' => 'margin-bottom: 10px; margin-right: 20px;']);
        } else {
            echo Html::a('Действующие приказы', ['orders/index'],
                ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 10px; margin-right: 20px;']);
        }
        if (Yii::$app->user->can('orderEditor') and $title == 'Приказы') {
            echo Html::a('Добавить приказ', ['orders/create'],
                ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px']);
        }

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'Файл',
                    'format' => 'html',
                    'value' => function ($model) {
                        $file = str_replace('/orders/', '', $model->file);
                        return Html::a($file, "@web/orders/$file");
                    }
                ],
                'caption:text',
                'number:text',
                [
                    'attribute' => 'date',
                    'format' => 'date',
                    'filter' => false,
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'visible' => Yii::$app->user->can('orderEditor') ? true : false,
                    'template' => '{archive}&nbsp&nbsp&nbsp{delete}',
                    'buttons' => [
                        'archive' => function ($url, $model) {
                            $class = null;
                            $title = null;
                            if ($model->isArchive) {
                                $class = 'glyphicon glyphicon-eject';
                                $title = 'Из архива';
                            } else {
                                $class = 'glyphicon glyphicon-download-alt';
                                $title = 'В архив';
                            }
                            return Html::a("<span class='$class'></span>", '', [
                                'class' => 'archive',
                                'data-id' => $model->id,
                                'title' => $title,
                            ]);
                        },
                    ],
                ],
            ],
        ]);
    ?>
</div>
