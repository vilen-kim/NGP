<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Auth;
use app\models\Pages;
use app\models\Menu;

class UserController extends \yii\web\Controller {



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
        $count = null;
        $count['auth'] = Yii::$app->user->can('auth') ? Auth::find()->count() : null;
        $count['menu'] = Yii::$app->user->can('menu') ? Menu::find()->count() : null;
        $count['pages'] = Yii::$app->user->can('page') ? Pages::find()->where(['category_id' => 1])->count() : null;
        $count['news'] = Yii::$app->user->can('news') ? Pages::find()->where(['category_id' => 2])->count() : null;
        $count['articles'] = Yii::$app->user->can('news') ? Pages::find()->where(['category_id' => 3])->count() : null;
        $count['events'] = Yii::$app->user->can('news') ? Pages::find()->where(['category_id' => 4])->count() : null;
        
        return $this->render('index', ['count' => $count]);
    }
}
