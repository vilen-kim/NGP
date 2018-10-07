<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;
    use yii\widgets\ActiveForm;
    app\assets\RequestAsset::register($this);
    $this->title = 'Ответ на обращение';
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Работа с обращениями', 'url' => ['kabinet/request']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container col-sm-8 col-sm-offset-2">
    <p>
        <b>Дата обращения:</b> <?= Yii::$app->formatter->asDate($request->request_created_at) ?>
    </p>
    <p>
        <b>Авторы:</b> <?= $authors ?>
    </p>
    <p>
        <b>Текст обращения:</b> <?= $request->request_text ?>
    </p>

    <div style="margin-top: 40px">
        <?php
            $form = ActiveForm::begin([
                'id' => 'answer-form',
            ]);
            echo $form->field($answer, 'answer_text')->textarea(['rows' => 6]);
            echo Html::beginTag('div', ['align' => 'center']);
                echo Html::submitButton('Отправить ответ', [
                    'class' => 'btn btn-008080',
                ]);
            echo Html::endTag('div');
            ActiveForm::end();
        ?>
    </div>
</div>