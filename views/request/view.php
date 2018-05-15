<?php

use yii\widgets\DetailView;

app\assets\RequestAsset::register($this);

if (Yii::$app->user->can('manager')){
    $this->title = 'Обращение';
    $this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Обращения', 'url' => ['request/index']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>

<div class="request-view row">
    <div class="col-md-8 col-md-offset-2">

        <h4 class="text-center"><b>Обращение:</b></h4>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'request_created_at:date',
                [
                    'label' => 'Кому',
                    'value' => $model->requestAuth->fio . ' - ' . $model->requestAuth->executive->position,
                ],
                [
                    'label' => 'Текст',
                    'value' => $model->request_text,
                ],
                [
                    'label' => 'Авторы',
                    'value' => $authors,
                    'format' => 'raw',
                ],
            ],
        ])
        ?>

        <h4 class="text-center"><b>Ответ:</b></h4>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'answer_created_at:date',
                [
                    'label' => 'Автор',
                    'value' => (isset($model->answerAuth)) ? $model->answerAuth->fio . ' - ' . $model->answerAuth->executive->position : null,
                ],
                [
                    'label' => 'Текст',
                    'value' => $model->answer_text,
                ],
            ],
        ])
        ?>
    </div>
</div>