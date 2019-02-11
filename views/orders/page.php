<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Страница приказов';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <?php

    echo Html::a('Действующие приказы', ['orders/index'],
        ['class' => 'btn btn-primary', 'style' => 'margin-bottom: 20px']);
    echo Html::a('Архивные приказы', ['orders/index', 'archive' => true],
        ['class' => 'btn btn-danger', 'style' => 'margin-bottom: 20px; margin-left: 20px;']);

    if (Yii::$app->user->can('manager')) {
//        echo Html::a('Добавить приказ', Url::to(['orders/create']), [
//            'class' => 'btn btn-success',
//            'style' => 'margin: 0px 0px 20px 20px;'
//        ]);
        echo Html::a('Изменить страницу', Url::to(['orders/update-page']), [
            'class' => 'btn btn-warning',
            'style' => 'margin: 0px 0px 20px 20px;'
        ]);
    }

    echo Html::beginTag('div');
        if (isset($model->text)){
            echo $model->text;
        } else {
            echo '';
        }
    echo Html::endTag('div');
    ?>
</div>
