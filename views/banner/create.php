<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	$this->title = 'Добавить баннер';
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-md-6 col-md-offset-3">

		<?php
			$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
	    	echo $form->field($model, 'image')->fileInput();
	    	echo $form->field($model, 'url')->textInput();
	    	echo $form->field($model, 'main')->checkbox();
	   	?>
	   	
    	<div align="center">
    		<?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
    	</div>
    		
    	<?php ActiveForm::end() ?>

	</div>

</div>
