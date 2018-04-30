<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class RbacController extends Controller {



    public function actionInit() {
        $am = Yii::$app->authManager;
        $am->removeAll();

        // Пользователь - работа в своем личном кабинете
        $user = $am->createRole('user');
        $am->add($user);

        // Редактор - может все что и пользователь + работа со страницами
        $editor = $am->createRole('editor');
        $am->add($editor);
        $am->addChild($editor, $user);

        // Менеджер - может все что и редактор + работа с меню
        $manager = $am->createRole('manager');
        $am->add($manager);
        $am->addChild($manager, $editor);

        // Администратор - может все что и менеджер + администрирование пользователей
        $admin = $am->createRole('admin');
        $am->add($admin);
        $am->addChild($admin, $manager);
    }
}
