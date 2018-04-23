<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\Auth;
use app\models\forms\RegisterForm;
use app\models\forms\LoginForm;
use app\models\AuthSearch;
use app\models\AuthItem;
use yii\helpers\ArrayHelper;

class AuthController extends Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['auth'],
                    ],
                    [
                        'actions' => ['login', 'register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $searchModel = new AuthSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }



    public function actionCreate() {
        $model = new RegisterForm;
        $model->scenario = RegisterForm::SCENARIO_CREATE;


        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            Yii::$app->session->setFlash('success', 'Учетная запись была успешно создана.');
            return $this->redirect('index');
        }

        $roles = AuthItem::findAll(['type' => 1]);
        return $this->render('create', [
                'model' => $model,
                'roles' => ArrayHelper::map($roles, 'name', 'description'),
        ]);
    }



    public function actionRegister() {
        $model = new RegisterForm;
        $model->scenario = RegisterForm::SCENARIO_REGISTER;

        if ($model->load(Yii::$app->request->post()) && ($auth = $model->register())) {
            Yii::$app->session->setFlash('success', 'Ваша учетная запись была успешно зарегистрирована.<br>Дождитесь ее активации администратором сайта.');
            return $this->redirect('login');
        }

        return $this->render('register', [
                'model' => $model,
        ]);
    }



    public function actionActivate($id) {
        if ($model = $this->findModel($id)) {
            $model->status = Auth::STATUS_ACTIVE;
            $model->save();
        }
        return $this->redirect(['auth/index']);
    }



    public function actionDeactivate($id) {
        if ($model = $this->findModel($id)) {
            $model->status = Auth::STATUS_INACTIVE;
            $model->save();
        }
        return $this->redirect(['auth/index']);
    }



    public function actionLogin() {
        $model = new LoginForm;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                return $this->redirect(["admin/index"]);
            }
        }
        return $this->render('login', ['model' => $model]);
    }



    public function actionLogout() {
        Yii::$app->user->logout();
        $this->redirect(Url::to(['site/index']));
    }



    public function actionDelete($id) {
        if ($model = $this->findModel($id)) {
            $username = $model->username;
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', "Пользователь '$username' был успешно удален.");
            }
        }
        return $this->redirect(['auth/index']);
    }



    public function actionUpdate($id) {
        if ($auth = $this->findModel($id)) {
            $model = new RegisterForm;
            $model->scenario = RegisterForm::SCENARIO_UPDATE;
            $model->username = $auth->username;
            $model->role = $auth->item['name'];

            if ($model->load(Yii::$app->request->post()) && ($auth = $model->update($auth))) {
                Yii::$app->session->setFlash('success', "Учетная запись '$auth->username' была успешно изменена.");
                return $this->redirect('index');
            }

            $roles = AuthItem::findAll(['type' => 1]);
            return $this->render('update', [
                    'model' => $model,
                    'roles' => ArrayHelper::map($roles, 'name', 'description'),
            ]);
        }
    }



    protected function findModel($id) {
        if (($model = Auth::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
