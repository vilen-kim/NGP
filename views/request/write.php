<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;

app\assets\RequestAsset::register($this);
$this->title = 'Написать письмо';
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="request-write">

    <div class="row">
        <div class="col-md-8 col-md-offset-2 border">
            <p style="margin-bottom: 20px;"><i>Поля, отмеченные *, обязательны для заполнения</i></p>
            <?php
                $mainForm = ActiveForm::begin([
                    'action' => ['request/write'],
                    'id' => 'letter-form',
                ]);
                    echo Html::label('* Кому Вы направляете обращение', 'executive_id', ['class' => 'control-label']);
                    echo Html::radioList('typeExecutive', 'fio', $radioArray, [
                        'item' => function($index, $label, $name, $checked, $value) {
                            return '<div class="radio"><label>' . Html::radio($name, $checked, ['value' => $value]) . $label . '</label></div>';
                        },
                    ]);
                    echo $mainForm->field($letter, 'request_auth_id')->dropDownList($executiveArray, ['id' => 'executive_id']);
                    echo $mainForm->field($letter, 'request_text')->textarea(['rows' => 6]);
                    echo $mainForm->field($letter, 'reCaptcha')->widget(ReCaptcha::className())->label(false);
                ActiveForm::end();
            ?>
        </div>
    </div>

    <div class="col-md-12 text-center" style="margin-top: 20px;"><h4>Автор/соавторы обращения</h4></div>

    <div class="col-md-8 col-md-offset-2 border">
        <div id="curAuthor">
            <?php
            $form = ActiveForm::begin([
                    'action' => ['request/get-next-author'],
                    'id' => 'author-form',
            ]);
            echo $form->field($model, 'lastname');
            echo $form->field($model, 'firstname');
            echo $form->field($model, 'middlename');
            echo $form->field($model, 'organization');
            echo $form->field($model, 'email');
            echo $form->field($model, 'phone');
            echo '<i>Перед добавлением соавтора обращения, убедитесь, что все данные текущего автора (соавтора)'
            . ' введены правильно, поскольку они будут недоступны для изменения.</i><br><br>';
            echo Html::submitButton('Добавить соавтора(ов) обращения', [
                'class' => 'btn btn-default changeBack',
                'form' => 'author-form',
            ]);
            ActiveForm::end();
            ?>
        </div>

        <!-- Блок предыдущих соавторов -->
        <div id="titlePrevAuthors" class="hidden">Другие соавторы:</div>
        <ol id="prevAuthors"></ol>

    </div>
    <div class="col-md-8 col-md-offset-2 text-justify" style="margin-top: 20px; margin-bottom: 20px;">
        <p><i>
                Данное обращение будет сохранено в "Личном кабинете" у каждого автора/соавтора обращения. В случае отсутствия
                "Личного кабинета" он будет автоматически создан и автору/соавтору будет отправлено письмо на его
                адрес электронной почты с инструкцией по активации доступа в "Личный кабинет" и подтверждением отправки обращения.
            </i></p>
        <div class="text-center">
            <?= Html::submitButton('Отправить письмо', [
                'id' => 'mainSubmit',
                'class' => 'btn btn-success',
                'form' => 'letter-form',
            ]) ?>
        </div>
    </div>
</div>