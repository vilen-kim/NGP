<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    app\assets\AuthAsset::register($this);
    $this->title = $model->lastname . ' ' . $model->firstname . ' ' . $model->middlename;
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['auth/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-md-6 col-md-offset-3">

        <?php $form = ActiveForm::begin(); ?>
        
        <h2 class="text-center" style="margin-top: 0">Учетная запись</h2>
        <?php
            echo $form->field($model, 'email')->textInput(['readOnly' => true])->label(false);
            echo $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль (если хотите поменять)'])->label(false);
            echo $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => 'Повторите пароль'])->label(false);
            echo $form->field($model, 'role')->dropDownList($roles)->label(false);
        ?>
        
        <h2 class="text-center">Профиль</h2>
        <?php
            echo $form->field($model, 'lastname')->textInput(['placeholder' => 'Фамилия'])->label(false);
            echo $form->field($model, 'firstname')->textInput(['placeholder' => 'Имя'])->label(false);
            echo $form->field($model, 'middlename')->textInput(['placeholder' => 'Отчество'])->label(false);
        ?>
        
        <h2 class="text-center">Должностное лицо</h2>
        <?php
            echo $form->field($model, 'executive')->checkbox();
            echo $form->field($model, 'position')->textInput(['placeholder' => 'Должность'])->label(false);
            echo $form->field($model, 'kab')->textInput(['placeholder' => 'Кабинет'])->label(false);
            echo $form->field($model, 'priem')->textInput(['placeholder' => 'Время приема'])->label(false);
        ?>
        
        <div class="text-center">
            <?= Html::submitButton('Изменить', ['class' => 'btn btn-008080']) ?>
        </div>
        
        <?php ActiveForm::end(); ?>

    </div>
    
    <div class="col-md-3" style="padding-top: 92px;">
        Требования к паролю:
        <ul>
            <li><span id="length" class='text-danger'>Длина не менее 6 символов</span></li>
            <li><span id="big" class='text-danger'>Прописные латинские буквы</span></li>
            <li><span id="small" class='text-danger'>Строчные латинские буквы</span></li>
            <li><span id="number" class='text-danger'>Цифры</span></li>
        </ul>
    </div>
</div>