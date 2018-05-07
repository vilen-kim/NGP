<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

app\assets\RequestAsset::register($this);
$this->title = 'Написать письмо';
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="request-write">

    <?php
        Html::beginForm(['request/write'], 'post');
        $radioArray = [
            'fio' => 'Фамилия, имя, отчество должностного лица',
            'position' => 'Должность должностного лица',
            'organization' => 'БУ ХМАО-Югры "Няганская городская поликлиника"',
        ];
    ?>

    <div class="row">
        <div class="col-md-8 col-md-offset-2 border">
            <p style="margin-bottom: 20px;"><i>Поля, отмеченные *, обязательны для заполнения</i></p>
            <div class="form-group">
                <?= Html::label('* Кому Вы направляете обращение', 'whom_id', ['class' => 'control-label']) ?>
                <?= Html::radioList('typeWhom', 'fio', $radioArray, [
                    'item' => function($index, $label, $name, $checked, $value) {
                        return '<div class="radio"><label>' . Html::radio($name, $checked, ['value' => $value]) . $label . '</label></div>';
                    },
                ]) ?>
                <?= Html::dropDownList('whom_id', null, $whomArray, ['id' => 'whom_id', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= Html::label('* Текст обращения', 'text', ['class' => 'control-label']) ?>
                <?= Html::textarea('text', '', ['id' => 'text', 'class' => 'form-control', 'rows' => 6]) ?>
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
                . ' введены правильно, поскольку они будут недоступны для изменения.</i><br>';
                echo Html::submitButton('Добавить соавтора(ов) обращения', ['id' => 'addAuthor', 'class' => 'btn btn-default changeBack']);
                ActiveForm::end();
            ?>
            </div>
            
            <!-- Блок предыдущих соавторов -->
            <div id="titlePrevAuthors" class="hidden">Другие соавторы:</div>
            <ol id="prevAuthors"></ol>
            
        </div>
        <div class="col-md-8 col-md-offset-2 text-justify" style="margin-top: 20px;">
            <p><i>
                Данное обращение будет сохранено в "Личном кабинете" у каждого автора/соавтора обращения. В случае отсутствия
                "Личного кабинета" он будет автоматически создан и автору/соавтору будет отправлено письмо на его
                адрес электронной почты с инструкцией по активации доступа в "Личный кабинет" и подтверждением отправки обращения.
            </i></p>
            <div class="text-center">
                <?= Html::submitButton('Отправить письмо', ['sendRequest', 'class' => 'btn btn-default changeBack']) ?>
            </div>
        </div>
    </div>

    <?= Html::endForm() ?>
</div>