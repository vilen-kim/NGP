<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Auth;
use app\models\Pages;
use app\models\Menu;
use app\models\RequestWhom;

class AdminController extends \yii\web\Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'manager', 'editor'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }



    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }



    public function actionIndex() {
        $count = null;
        $count['users'] = Auth::find()->count();
        $count['menu'] = Menu::find()->count();
        $count['pages'] = Pages::find()->count();
        

        return $this->render('index', ['count' => $count]);
    }
}
