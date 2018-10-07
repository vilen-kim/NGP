<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use himiklab\yii2\recaptcha\ReCaptcha;
    app\assets\RequestAsset::register($this);
    $this->title = 'Регистрация обращения';
    if (Yii::$app->user->can('user')){
        $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
        $this->params['breadcrumbs'][] = ['label' => 'Работа с обращениями', 'url' => ['kabinet/request']];
    }
    $this->params['breadcrumbs'][] = $this->title;
?>

<?php
    if (!Yii::$app->mobileDetect->isMobile()){
        $style = 'margin-top: -30px; margin-bottom: 20px';
    } else {
        $style = 'margin-bottom: 20px';
    }
?>
<div class="container" style="<?= $style ?>">
    <div class="col-sm-6"><?= Html::a('Ответы на обращения, затрагивающие<br>интересы неопределенного круга лиц', ['site/share'], ['class' => 'btn btn-primary']) ?></div>
    <div class="col-sm-6"><?php
        $pdf = Html::img('/images/icons/pdf.svg', ['class' => 'pull-left', 'height' => '30px', 'style' => 'margin: 5px;']);
        echo Html::a($pdf . ' Информация для ознакомления, желающим отправить обращение в форме электронного документа', '/documents/RequestInformation.pdf');
    ?></div>
</div>

<h1><?= $this->title ?></h1>

<div class="request-write container">

    <div class="col-sm-8 col-sm-offset-2 border">        
        <?php

            $mainForm = ActiveForm::begin([
                'action' => ['request/create-request-and-authors'],
                'id' => 'letter-form',
            ]);
                echo Html::label('Кому Вы направляете обращение', 'executive_id', ['class' => 'control-label']);
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

    <div class="col-sm-12" align="center">
        <h2>Автор/соавторы обращения</h2>
    </div>

    <div class="col-sm-8 col-sm-offset-2 border">
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
            echo Html::beginTag('div', ['align' => 'center']);           
                echo Html::submitButton('Добавить соавтора(ов) обращения', [
                    'class' => 'btn btn-success',
                    'form' => 'author-form',
                ]);
            echo Html::endTag('div');
            ActiveForm::end();
            ?>
        </div>

        <!-- Блок предыдущих соавторов -->
        <div id="titlePrevAuthors" class="hidden">Другие соавторы:</div>
        <ol id="prevAuthors"></ol>

    </div>

    <div class="col-sm-8 col-sm-offset-2 text-justify" style="margin-top: 20px; margin-bottom: 20px;">
        <p><i>
            Данное обращение будет сохранено в "Личном кабинете" у каждого автора/соавтора обращения.
            В случае отсутствия "Личного кабинета" он будет автоматически создан и автору/соавтору будет
            отправлено письмо на его адрес электронной почты с дальнейшими инструкциями.
        </i></p>
        <div class="text-center">
            <?= Html::submitButton('Отправить письмо', [
                'id' => 'mainSubmit',
                'class' => 'btn btn-008080',
                'form' => 'letter-form',
            ]) ?>
        </div>
    </div>
</div>