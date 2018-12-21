<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Изменить улицу';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
$this->params['breadcrumbs'][] = ['label' => 'Терапевтические участки', 'url' => ['kabinet/regions']];
$this->params['breadcrumbs'][] = ['label' => 'Улицы', 'url' => ['region/street-index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-sm-6 col-sm-offset-3">

		<?php
			$form = ActiveForm::begin();
	    	echo $form->field($model, 'caption')->textInput(['maxlength' => true]);
	   	?>
	   	
    	<div align="center">
    		<?= Html::submitButton('Изменить', ['class' => 'btn btn-008080']) ?>
    	</div>
    		
    	<?php ActiveForm::end() ?>

	</div>
</div>