<?php
	use yii\helpers\Html;
	use yii\widgets\DetailView;
?>

<div>
    <h2 align="center">Уважаемый $model->fio</h2>
    Вами сделана заявка на вызов врача на дом и указаны следующие реквизиты:
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'phone',
            'address',
            'email:email',
            'text',
        ],
    ]) ?>
    Как только заявка будет отработана, мы вам позвоним.
</div>