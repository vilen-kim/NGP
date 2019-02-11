<?php

use yii\helpers\Html;

echo Html::beginTag('div', ['class' => 'admin-menu']);
$imageStyle = ['height' => 25, 'style' => 'margin-right: 10px; max-width: 30px'];

// Роль - пользователь
if (Yii::$app->user->can('user')) {
    echo Html::tag('p', 'Пользователь', ['class' => 'medium-bold']);

    $text = 'Работа с обращениями';
    $url = ['kabinet/request'];
    $img = Html::img("@web/images/icons/kabinet/request.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));

    $text = 'Профиль пользователя';
    $url = ['kabinet/profile'];
    $img = Html::img("@web/images/icons/kabinet/profile.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));
}

// Роль - сотрудник
if (Yii::$app->user->can('employee')) {
    echo Html::tag('p', 'Сотрудник', ['class' => 'medium-bold']);

    $text = 'Внутренние приказы';
    $url = ['orders/page'];
    $img = Html::img("@web/images/icons/kabinet/orders.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));
}

// Роль - регистратор
if (Yii::$app->user->can('registrator')) {
    echo Html::tag('p', 'Регистратор', ['class' => 'medium-bold']);

    $text = 'Регистрация вызова врача';
    $url = ['call-doctor/index'];
    $img = Html::img("@web/images/icons/kabinet/doctor.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));
}

// Роль - редактор
if (Yii::$app->user->can('editor')) {
    echo Html::tag('p', 'Редактор', ['class' => 'medium-bold']);

    $text = 'Страницы';
    $url = ['pages/index'];
    $img = Html::img("@web/images/icons/kabinet/adminPages.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));

    $text = 'Записи из ВК';
    $url = ['vk/get-wall'];
    $img = Html::img("@web/images/icons/kabinet/adminNews.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));
}

// Роль - менеджер
if (Yii::$app->user->can('manager')) {
    echo Html::tag('p', 'Менеджер', ['class' => 'medium-bold']);

    $text = 'Меню';
    $url = ['menu/index'];
    $img = Html::img("@web/images/icons/kabinet/adminMenu.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));

    $text = 'Обращения';
    $url = ['request/index'];
    $img = Html::img("@web/images/icons/kabinet/adminRequest.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));

    $text = 'Баннеры';
    $url = ['banner/index'];
    $img = Html::img("@web/images/icons/kabinet/adminBanners.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));
}

// Роль - администратор
if (Yii::$app->user->can('admin')) {
    echo Html::tag('p', 'Администратор', ['class' => 'medium-bold']);

    $text = 'Пользователи';
    $url = ['auth/index'];
    $img = Html::img("@web/images/icons/kabinet/adminUsers.svg", $imageStyle);
    echo Html::tag('p', Html::a($img . $text, $url));
}

echo Html::endTag('div');