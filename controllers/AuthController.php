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
use app\models\forms\ForgotPassForm;
use app\models\forms\NewPasswordForm;
use app\models\forms\ActivateForm;
use yii\web\Response;

class AuthController extends Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
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



    public function actionRegister() {
        $model = new RegisterForm;
        if ($model->load(Yii::$app->request->post())) {
            $auth = $model->register();
            if ($auth) {
                Yii::$app->session->setFlash('success', 'Ваша учетная запись была успешно зарегистрирована.<br>Дождитесь ее активации администратором сайта.');
                $this->redirect('login');
            } else {
                Yii::$app->session->setFlash('danger', 'Произошла ошибка. Повторите попытку регистрации позже.');
                $this->redirect('register');
            }
        } else {
            return $this->render('register', [
                    'model' => $model
            ]);
        }
    }



    public function actionActivate($token = null) {
        if ($token) {
            $auth = Auth::findByPasswordResetToken($token);
            if ($auth) {
                $auth->status = Auth::STATUS_ACTIVE;
                $auth->removePasswordResetToken();
                if ($auth->save()) {
                    Yii::$app->user->login($auth);
                    Yii::$app->session->setFlash('success', 'Ваша учетная запись была успешно активирована. Добро пожаловать.');
                }
            }
            $this->redirect(Url::previous());
        } else {
            $model = new ActivateForm;
            $model->email = Yii::$app->request->post('email');
            if ($model->validate() && $model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Для активации пройдите по ссылке, отправленной Вам на электронную почту.');
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка отправки электронного письма. Повторите попытку активации позже.');
            }
            return true;
        }
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



    public function actionForgotPass() {
        $model = new ForgotPassForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'На Вашу электронную почту отправлено письмо с инструкцией по сбросу пароля.');
                return "OK";
            }
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('forgotpass', ['model' => $model]);
        }
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
                        Yii::$app->session->setFlash('danger', 'Произошла ошибка во время сохранения пароля в базе данных. Попробуйте позже.');
                    }
                } else {
                    return $this->render('newPassword', [
                            'model' => $model,
                            'email' => $auth->email,
                    ]);
                }
            }
            $this->redirect(Url::previous());
        }
    }
}
