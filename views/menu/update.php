<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\jui\AutoComplete;
    use yii\web\JsExpression;
    app\assets\MenuAsset::register($this);
    $this->title = $model->caption;
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['menu/index']];
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-sm-6 col-sm-offset-3 border">

        <?php
            $pageCaption = ($model->page_id) ? $model->page->caption : '';
            $form = ActiveForm::begin();
        ?>
        <?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'parent_id')->dropDownList($parents) ?>
        <div class="form-group">
            <?= Html::label('Страница') ?>
            <?= AutoComplete::widget([
                'clientOptions' => [
                    'source' => $pages,
                    'autoFocus' => true,
                    'select' => new JsExpression("function(event, ui) {
                        id = ui.item.value;
                        $('#page_id').val(id);
                        page_id = id;
                        getAnchors(id);
                    }"),
                    'change' => new JsExpression("function(event, ui) {
                        $(this).val(ui.item.label);
                    }"),
                    'create' => new JsExpression("function(event, ui) {
                        id = $('#page_id').val();
                        page_id = id;
                        $(this).val('$pageCaption');
                    }"),
                ],
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => 'Введите заголовок страницы...',
                    'id' => 'autoPage_id',
                    'disabled' => ($model->page_id == 0) ? true : false,
                ],
            ]) ?>
            <?= Html::activeHiddenInput($model, 'page_id', ['id' => 'page_id']) ?>
            <?= Html::label('Без страницы', 'emptyPage', ['style' => 'font-weight: normal']) ?>
            <?= Html::checkbox('emptyPage', (!$model->page_id), ['style' => 'margin-left: 5px', 'id' => 'emptyPage']) ?>
        </div>
        <?= $form->field($model, 'anchor')->dropDownList($anchors, ['id' => 'anchor']) ?>

        <div align="center">
            <?= Html::submitButton('Изменить', ['class' => 'btn btn-008080']) ?>
        </div>
        
        <?php ActiveForm::end(); ?>

    </div>
</div>
