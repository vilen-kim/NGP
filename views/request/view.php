<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
app\assets\RequestAsset::register($this);
$this->title = 'Просмотр обращения';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
$this->params['breadcrumbs'][] = ['label' => 'Обращения', 'url' => ['request/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="request-view row">
    <div class="col-md-8 col-md-offset-2">

        <h2 align="center"><b>Обращение</b></h2>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'request_created_at:date',
                [
                    'label' => 'Кому',
                    'value' => function($model){
                        $text = $model->requestAuth->fio;
                        if (isset($model->requestAuth->executive)){
                            $text .= ' - ' . $model->requestAuth->executive->position;
                        }
                        return $text;
                    }
                ],
                [
                    'label' => 'Текст',
                    'value' => $model->request_text,
                ],
                [
                    'label' => 'Автор(ы)',
                    'value' => $authors,
                    'format' => 'raw',
                ],
            ],
        ])
        ?>

        <h2 align="center"><b>Ответ</b></h2>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'answer_created_at:date',
                [
                    'label' => 'Автор',
                    'value' => function($model){
                        $text = '';
                        if (isset($model->answerAuth)){
                            $text .= $model->answerAuth->fio;
                            if (isset($model->answerAuth->executive)){
                                $text .= ' - ' . $model->answerAuth->executive->position;
                            }
                        }
                        return $text;
                    }
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