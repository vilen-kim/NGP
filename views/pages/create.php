<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\components\Editor;
app\assets\CKEditorAsset::register($this);

$this->title = $tt['title'];
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => $tt['type'], 'url' => ['pages/index', 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="pages-create">

    <?php
    $form = ActiveForm::begin();
    echo $form->field($model, 'caption')->textInput(['maxlength' => true]);
    echo $form->field($model, 'category_id')->hiddenInput()->label(false);
    echo $form->field($model, 'auth_id')->hiddenInput()->label(false);
    echo $form->field($model, 'text')->widget(Editor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full',
        'clientOptions' => Yii::$app->params['ckeditorClientOptions'],
    ]);
    ?>
    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div>
