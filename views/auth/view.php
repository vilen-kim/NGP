<?php

use yii\widgets\DetailView;

app\assets\AuthAsset::register($this);
$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['auth/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <h4 class="text-center"><b>Учетная запись:</b></h4>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'email:email',
                'description:text:Роль',
                'created_at:date',
                'updated_at:date',
                'login_at:date',
            ],
        ]) ?>
        
        <h4 class="text-center"><b>Профиль:</b></h4>
        <?= DetailView::widget([
            'model' => $model->profile,
            'attributes' => [
                'lastname',
                'firstname',
                'middlename',
                'birthdate',
                'address',
                'phone',
                'organization',
            ],
        ]) ?>
        
        <?php if (isset($model->executive)){ ?>
        <h4 class="text-center"><b>Должностное лицо:</b></h4>
        <?= DetailView::widget([
            'model' => $model->executive,
            'attributes' => [
                'position',
                'kab',
                'priem',
            ],
        ]) ?>
        <?php } ?>

    </div>
</div>