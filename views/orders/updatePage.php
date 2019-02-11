<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use app\components\Editor;
    app\assets\CKEditorAsset::register($this);
    $this->title = 'Страница приказов';
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Приказы', 'url' => ['orders/page']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
        <?php
        $form = ActiveForm::begin();
        echo $form->field($model, 'text')->widget(Editor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'full',
            'clientOptions' => Yii::$app->params['ckeditorClientOptions'],
        ]);
        echo Html::beginTag('div', ['align' => 'center']);
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-008080']);
        echo Html::endTag('div');
        ActiveForm::end();
        ?>

</div>
