<?php

use yii\widgets\DetailView;

app\assets\RequestAsset::register($this);
$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Адресаты обращений', 'url' => ['request/whom']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'lastname',
                'firstname',
                'middlename',
                'email:email',
                'phone',
                'position',
                'kab',
                'priem',
                'organization',
            ],
        ]) ?>
        
    </div>
</div>