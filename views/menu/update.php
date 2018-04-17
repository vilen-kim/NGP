<?php

$this->title = 'Редактирование элемента меню';
$this->params['breadcrumbs'][] = ['label' => 'Панель управления', 'url' => ['admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Меню', 'url' => ['menu/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>
<div class="menu-update">

    <?= $this->render('_form', [
        'model' => $model,
        'parents' => $parents,
        'pages' => $pages,
    ]) ?>

</div>
