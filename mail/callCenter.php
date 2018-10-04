<?php
	use yii\helpers\Html;
	use yii\widgets\DetailView;
?>

<div>
    <p>Сделана заявка на вызов врача:</p>
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            'phone',
            'address',
            'email:email',
            'text',
        ],
    ]) ?>
</div>