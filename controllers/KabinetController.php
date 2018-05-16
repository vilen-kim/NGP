<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Request;
use app\models\RequestUser;

class KabinetController extends \yii\web\Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user'],
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
        $user_id = Yii::$app->user->id;
        $model = RequestUser::find()
        ->where(['auth_id' => $user_id])
        ->joinWith(['request'])
        ->orderBy(['request_created_at' => SORT_DESC])
        ->all();
        $haveRequest = Request::findAll(['request_auth_id' => $user_id]);
        $countUnanswered = Request::find()->where(['request_auth_id' => $user_id, 'answer_text' => null])->count();
        return $this->render('index', [
            'model' => $model,
            'haveRequest' => $haveRequest,
            'countUnanswered' => $countUnanswered,
            'user_id' => $user_id,
        ]);
    }
}
