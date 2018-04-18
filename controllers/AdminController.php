<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Auth;
use app\models\Pages;
use app\models\Menu;
use yii\web\ForbiddenHttpException;

class AdminController extends \yii\web\Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin_index'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }



    public function actionIndex() {
        $usersCount = Auth::find()->count();
        $pagesCount = Pages::find()->where(['category_id' => 1])->count();
        $newsCount = Pages::find()->where(['category_id' => 2])->count();
        $articlesCount = Pages::find()->where(['category_id' => 3])->count();
        $eventsCount = Pages::find()->where(['category_id' => 4])->count();
        $menuCount = Menu::find()->count();
        return $this->render('index', [
                'usersCount' => $usersCount,
                'pagesCount' => $pagesCount,
                'newsCount' => $newsCount,
                'articlesCount' => $articlesCount,
                'eventsCount' => $eventsCount,
                'menuCount' => $menuCount,
        ]);
    }
}
