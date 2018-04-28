<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;
        
        $auth->removeAll();
        
        $admin = $auth->createRole('admin');
        $user = $auth->createRole('auth');
        $menu = $auth->createRole('menu');
        $page = $auth->createRole('page');
        $news = $auth->createRole('news');
        
        $auth->add($admin);
        $auth->add($user);
        $auth->add($menu);
        $auth->add($page);
        $auth->add($news);
        
        
        
        $admin_index = $auth->createPermission('admin_index');
        
        $auth_index = $auth->createPermission('auth_index');
        $auth_create = $auth->createPermission('auth_create');
        $auth_view = $auth->createPermission('auth_view');
        $auth_update = $auth->createPermission('auth_update');
        $auth_delete = $auth->createPermission('auth_delete');
        
        $menu_index = $auth->createPermission('menu_index');
        $menu_create = $auth->createPermission('menu_create');
        $menu_view = $auth->createPermission('menu_view');
        $menu_update = $auth->createPermission('menu_update');
        $menu_delete = $auth->createPermission('menu_delete');
        
        $page_index = $auth->createPermission('page_index');
        $page_create = $auth->createPermission('page_create');
        $page_view = $auth->createPermission('page_view');
        $page_update = $auth->createPermission('page_update');
        $page_delete = $auth->createPermission('page_delete');
        
        $news_index = $auth->createPermission('news_index');
        $news_create = $auth->createPermission('news_create');
        $news_view = $auth->createPermission('news_view');
        $news_update = $auth->createPermission('news_update');
        $news_delete = $auth->createPermission('news_delete');
        
        
        
        $auth->add($admin_index);
        
        $auth->add($auth_index);
        $auth->add($auth_create);
        $auth->add($auth_view);
        $auth->add($auth_update);
        $auth->add($auth_delete);
        
        $auth->add($menu_index);
        $auth->add($menu_create);
        $auth->add($menu_view);
        $auth->add($menu_update);
        $auth->add($menu_delete);
        
        $auth->add($page_index);
        $auth->add($page_create);
        $auth->add($page_view);
        $auth->add($page_update);
        $auth->add($page_delete);
        
        $auth->add($news_index);
        $auth->add($news_create);
        $auth->add($news_view);
        $auth->add($news_update);
        $auth->add($news_delete);
        
        $auth->addChild($news, $admin_index);
        
        $auth->addChild($news, $news_index);
        $auth->addChild($news, $news_create);
        $auth->addChild($news, $news_view);
        $auth->addChild($news, $news_update);
        $auth->addChild($news, $news_delete);
        
        $auth->addChild($page, $news);
        $auth->addChild($page, $page_index);
        $auth->addChild($page, $page_create);
        $auth->addChild($page, $page_view);
        $auth->addChild($page, $page_update);
        $auth->addChild($page, $page_delete);
        
        $auth->addChild($menu, $page);
        $auth->addChild($menu, $menu_index);
        $auth->addChild($menu, $menu_create);
        $auth->addChild($menu, $menu_view);
        $auth->addChild($menu, $menu_update);
        $auth->addChild($menu, $menu_delete);
        
        $auth->addChild($user, $menu);
        $auth->addChild($user, $auth_index);
        $auth->addChild($user, $auth_create);
        $auth->addChild($user, $auth_view);
        $auth->addChild($user, $auth_update);
        $auth->addChild($user, $auth_delete);
        
        $auth->addChild($admin, $user);
    }
}