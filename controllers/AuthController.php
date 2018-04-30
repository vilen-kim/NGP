<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\Auth;
use app\models\forms\RegisterForm;
use app\models\forms\ActivateForm;
use app\models\forms\LoginForm;
use app\models\forms\ForgotPassForm;
use app\models\forms\NewPasswordForm;
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
                        'actions' => ['create', 'delete', 'update', 'index'],
                        'allow' => true,
                        'roles' => ['admin'],   // администратор
                    ],
                    [
                        'actions' => ['login', 'register', 'activate', 'forgot-pass', 'new-password'],
                        'allow' => true,
                        'roles' => ['?'],       // гость
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],       // авторизованный пользователь
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

        if ($model->load(Yii::$app->request->post())) {
            if ($auth = $model->register()) {
                Yii::$app->session->setFlash('success', 'Ваша учетная запись была успешно зарегистрирована.<br>Инструкция по ее активации отправлена Вам на электронную почту.');
                return $this->redirect('login');
            } else {
                Yii::$app->session->setFlash('danger', 'При активации учетной записи произошла ошибка. Попробуйте позже.');
            }
        }

        return $this->render('register', [
                'model' => $model,
        ]);
    }



    public function actionActivate($token = null, $email = null) {
        if ($token) {
            $auth = Auth::findByPasswordResetToken($token);
            if ($auth) {
                $auth->status = Auth::STATUS_ACTIVE;
                $auth->removePasswordResetToken();
                if ($auth->save()) {
                    Yii::$app->user->login($auth);
                    Yii::$app->session->setFlash('success', 'Ваша учетная запись была успешно активирована. Добро пожаловать.');
                    return $this->redirect(['admin/index']);
                }
            }
        }
        if ($email) {
            $model = new ActivateForm;
            $model->email = $email;
            if ($model->validate() && $model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Для активации пройдите по ссылке, отправленной Вам на электронную почту.');
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка отправки электронного письма. Повторите попытку активации позже.');
            }
        }
        return $this->redirect('login');
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



    public function actionForgotPass() {
        $model = new ForgotPassForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'На Вашу электронную почту отправлено письмо с инструкцией по сбросу пароля.');
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка отправки электронного письма. Повторите попытку активации позже.');
            }
            return $this->redirect(['login']);
        }

        return $this->render('forgotpass', [
                'model' => $model,
        ]);
    }



    public function actionNewPassword($token = null) {
        if ($token) {
            $auth = Auth::findByPasswordResetToken($token);
            if ($auth) {
                $model = new NewPasswordForm;

                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $auth->setPassword($model->password);
                    $auth->removePasswordResetToken();
                    if ($auth->save()) {
                        Yii::$app->session->setFlash('success', 'Пароль был успешно изменен.');
                    } else {
                        Yii::$app->session->setFlash('danger', 'Произошла ошибка во время изменения пароля. Попробуйте позже.');
                    }
                    return $this->redirect('login');
                }

                return $this->render('newPassword', [
                        'model' => $model,
                        'email' => $auth->email,
                ]);
            }
        }
        return $this->redirect('login');
    }



    protected function findModel($id) {
        if (($model = Auth::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
