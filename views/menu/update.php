<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

app\assets\MenuAsset::register($this);

$this->title = $model->caption;
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['menu/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>
<div class="row">
    <div class="col-md-6 col-md-offset-3 border">

        <?php
            $pageCaption = $model->page->caption;
            $form = ActiveForm::begin();
        ?>
        <?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'parent_id')->dropDownList($parents) ?>
        <div class="form-group">
            <?= Html::label('Страница') ?>
            <?= AutoComplete::widget([
                'clientOptions' => [
                    'source' => $pages,
                    'select' => new JsExpression("function(event, ui) {
                        id = ui.item.value;
                        $('#page_id').val(id);
                        getAnchors(id);
                    }"),
                    'change' => new JsExpression("function(event, ui) {
                        $(this).val(ui.item.label);
                    }"),
                    'create' => new JsExpression("function(event, ui) {
                        id = $('#page_id').val();
                        $(this).val('$pageCaption');
                    }"),
                ],
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Введите заголовок страницы...',
                ],
            ]) ?>
        <?= Html::activeHiddenInput($model, 'page_id', ['id' => 'page_id']) ?>
        </div>
        <?= $form->field($model, 'anchor')->dropDownList($anchors, ['id' => 'anchor']) ?>
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-default changeBack']) ?>
        <?php ActiveForm::end(); ?>

    </div>
</div>
