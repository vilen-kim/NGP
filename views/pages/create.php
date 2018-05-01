<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\components\Editor;
app\assets\CKEditorAsset::register($this);

$this->title = 'Создание новой страницы';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['pages/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div>

    <?php
    $form = ActiveForm::begin();
    echo $form->field($model, 'caption')->textInput(['maxlength' => true]);
    echo $form->field($model, 'category_id')->dropDownList($categories);
    echo $form->field($model, 'text')->widget(Editor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => Yii::$app->params['ckeditorClientOptions'],
    ]);
    echo Html::submitButton('Создать', ['class' => 'btn btn-default changeBack']);
    ActiveForm::end();
    ?>

</div>
