<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

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
            'model' => $request,
            'attributes' => [
                'request_created_at:date',
                [
                    'label' => 'Кому',
                    'value' => $request->requestAuth->fio . ' - ' . $request->requestAuth->executive->position,
                ],
                [
                    'label' => 'Текст',
                    'value' => $request->request_text,
                ],
                [
                    'label' => 'Автор(ы)',
                    'value' => $authors,
                    'format' => 'raw',
                ],
            ],
        ])
        ?>

        <h4 class="text-center"><b>Ваш ответ:</b></h4>
        <?php
            $form = ActiveForm::begin([
                'action' => ['request/create-answer'],
                'id' => 'answer-form',
            ]);
            echo $form->field($answer, 'answer_text')->textarea(['rows' => 6]);
            echo Html::submitButton('Отправить ответ', [
                'class' => 'btn btn-success',
            ]);
            ActiveForm::end();
        ?>
    </div>
</div>