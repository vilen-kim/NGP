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
                        'actions' => ['index', 'view', 'create', 'delete', 'update', ],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['login', 'register', 'activate', 'forgot-pass', 'new-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function($rule, $action){
                    Yii::$app->session->setFlash('danger', "У вас нет доступа к странице $action->id");
                    return $this->redirect(['kabinet/index']);
                }
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

        if ($model->load(Yii::$app->request->post())) {
            if ($auth = $model->register()) {
                Yii::$app->session->setFlash('success', 'Учетная запись была успешно создана.');
                return $this->redirect(['auth/view', 'id' => $auth->id]);
            }
        }

        $roles = AuthItem::findAll(['type' => 1]);
        $model->role = 'user';
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
                var_dump($auth);
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
                    if ($auth->password_hash == '12345') {   // Пользователь был создан автоматически и пароля еще нету.
                        $auth->generatePasswordResetToken();
                        $newToken = $auth->password_reset_token;
                        $auth->setPassword(Yii::$app->security->generateRandomString());
                        $auth->save();
                        Yii::$app->session->setFlash('info', 'Ваша учетная запись была успешно активирована. Теперь давайте создадим пароль.');
                        return $this->redirect(['auth/new-password', 'token' => $newToken]);
                    }
                    Yii::$app->user->login($auth);
                    Yii::$app->session->setFlash('success', 'Ваша учетная запись была успешно активирована. Добро пожаловать.');
                    return $this->redirect(['kabinet/index']);
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
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(["kabinet/index"]);
        }
        return $this->render('login', ['model' => $model]);
    }



    public function actionLogout() {
        Yii::$app->user->logout();
        $this->redirect(Url::to(['site/index']));
    }



    public function actionDelete($id) {
        if ($model = $this->findModel($id)) {
            if ($model->id == Yii::$app->user->id) {
                Yii::$app->session->setFlash('danger', "Нельзя удалять самого себя.");
                return $this->redirect('index');
            }
            $fio = $model->fio;
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', "Пользователь '$fio' был успешно удален.");
            }
        }
        return $this->redirect('index');
    }



    public function actionView($id = null) {
        $id = ($id == null) ? Yii::$app->user->id : $id;
        if (Yii::$app->user->can('admin')){
            $model = $this->findModel($id);
        } else {
            $model = $this->findModel(Yii::$app->user->id);
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }



    public function actionUpdate($id) {
        if ($auth = $this->findModel($id)) {
            $model = new RegisterForm;
            $model->scenario = RegisterForm::SCENARIO_UPDATE;
            $model->email = $auth->email;
            $model->firstname = $auth->profile->firstname;
            $model->lastname = $auth->profile->lastname;
            $model->middlename = $auth->profile->middlename;
            $model->role = $auth->item['name'];
            if (isset($auth->executive)) {
                $model->executive = true;
                $model->position = $auth->executive->position;
                $model->kab = $auth->executive->kab;
                $model->priem = $auth->executive->priem;
            }

            if ($model->load(Yii::$app->request->post()) && ($auth = $model->update($auth))) {
                Yii::$app->session->setFlash('success', "Учетная запись '$auth->fio' была успешно изменена.");
                return $this->redirect(['auth/view', 'id' => $auth->id]);
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
