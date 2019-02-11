<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    $this->title = 'Приказы';
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Страница приказов', 'url' => ['orders/page']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <?php
        if (Yii::$app->user->can('manager')) {
            echo Html::a('Добавить приказ', ['orders/create'],
                ['class' => 'btn btn-success', 'style' => 'margin-bottom: 10px']);
        }

        echo GridView::widget([
            'dataProvider' => $dataProvider,
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
                'date:date',
                [
                    'label' => 'В архиве',
                    'format' => 'html',
                    'value' => function ($model) {
                        if ($model->isArchive) {
                            return 'Да';
                        } else {
                            return '';
                        }
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                ],
            ],
        ]);
    ?>
</div>
