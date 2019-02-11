<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	$this->title = 'Добавить приказ';
	$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
	$this->params['breadcrumbs'][] = ['label' => 'Страница приказов', 'url' => ['orders/page']];
	$this->params['breadcrumbs'][] = ['label' => 'Приказы', 'url' => ['orders/index']];
	$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-sm-6 col-sm-offset-3">

		<?php
			$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
	    	echo $form->field($model, 'file')->fileInput();
	    	echo $form->field($model, 'caption')->textInput();
	    	echo $form->field($model, 'number')->textInput();
	    	echo $form->field($model, 'date')->textInput();
	   	?>
	   	
    	<div align="center">
    		<?= Html::submitButton('Добавить', ['class' => 'btn btn-008080']) ?>
    	</div>
    		
    	<?php ActiveForm::end() ?>

	</div>

</div>
