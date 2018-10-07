<?php
    use yii\widgets\DetailView;
    app\assets\AuthAsset::register($this);
    $this->title = $model->fio;
    $this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['kabinet/index']];
    $this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['auth/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-sm-8 col-sm-offset-2">

        <h2 align="center" style="margin-top: 0">Учетная запись</h2>
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
        
        <h2 align="center">Профиль</h2>
        <?= DetailView::widget([
            'model' => $model->profile,
            'attributes' => [
                'lastname',
                'firstname',
                'middlename',
                'birthdate:date',
                'address',
                'phone',
                'organization',
            ],
        ]) ?>
        
        <?php if (isset($model->executive)){ ?>
        <h2 align="center">Должностное лицо</h2>
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

<?php
    $this->registerCss('
        table.detail-view th {
            width: 30%;
        }
    ');