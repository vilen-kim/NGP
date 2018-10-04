<?php
	use yii\helpers\Html;
	use yii\widgets\DetailView;
?>

<div>
    <h2 align="center">Уважаемый <?= $model->fio ?></h2>
    <p>Вами сделана заявка на вызов врача на дом и указаны следующие реквизиты:</p>
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'phone',
            'address',
            'email:email',
            'text',
        ],
    ]) ?>
    <p>Как только заявка будет отработана, мы вам позвоним.</p>
</div>