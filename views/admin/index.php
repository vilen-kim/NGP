<?php

use yii\helpers\Html;
use yii\helpers\Url;

app\assets\AdminAsset::register($this);
$this->title = 'Панель управления';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="admin-index">
    <?= Html::a("Пользователи <span class='badge'>$usersCount</span>", Url::to(['admin/users']), ['class' => 'btn btn-success scale']) ?><br>
    <?= Html::a("Меню <span class='badge'>$menuCount</span>", Url::to(['menu/index']), ['class' => 'btn btn-primary scale']) ?><br>
    <?= Html::a("Страницы <span class='badge'>$pagesCount</span>", Url::to(['pages/index', 'category_id' => 1]), ['class' => 'btn btn-info scale']) ?><br>
    <?= Html::a("Новости <span class='badge'>$newsCount</span>", Url::to(['pages/index', 'category_id' => 2]), ['class' => 'btn btn-info scale']) ?><br>
    <?= Html::a("Статьи <span class='badge'>$articlesCount</span>", Url::to(['pages/index', 'category_id' => 3]), ['class' => 'btn btn-info scale']) ?><br>
    <?= Html::a("Мероприятия <span class='badge'>$eventsCount</span>", Url::to(['pages/index', 'category_id' => 4]), ['class' => 'btn btn-info scale']) ?>
</div>