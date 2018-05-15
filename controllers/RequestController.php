<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use app\models\forms\AuthorForm;
use app\models\forms\LetterForm;
use app\models\forms\ActivateForm;
use app\models\Request;
use app\models\RequestExecutive;
use app\models\RequestUser;
use app\models\RequestSearch;
use app\models\Auth;
use app\models\Errors;

class RequestController extends \yii\web\Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['manager'], // менеджер
                    ],
                    [
                        'actions' => ['get-executive', 'get-next-author', 'info', 'write'],
                        'allow' => true,
                        'roles' => ['?'], // гость
                    ],
                    [
                        'actions' => ['active', 'get-executive', 'get-next-author', 'info', 'view', 'write'],
                        'allow' => true,
                        'roles' => ['@'], // авторизованный пользователь
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
        $searchModel = new RequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionView($id) {
        if (!Yii::$app->user->can('manager') && !RequestUser::findOne(['request_id' => $id, 'auth_id' => Yii::$app->user->id])){
            throw new \yii\web\ForbiddenHttpException('У вас нет прав доступа.');
        }
        $model = $this->findModel($id);
        $authors = null;
        foreach ($model->requestUsers as $user) {
            $authors .= $user->auth->fio;
            if ($user->active == RequestUser::STATUS_INACTIVE) {
                $authors .= ' (-)';
            }
            $authors .= '<br>';
        }
        return $this->render('view', [
            'model' => $model,
            'authors' => $authors,
        ]);
    }



    public function actionInfo() {
        return $this->render('info');
    }



    public function actionWrite() {
        $author = new AuthorForm;
        $letter = new LetterForm;

        if ($letter->load(Yii::$app->request->post()) && $author->load(Yii::$app->request->post())) {
            $countAuthors = 0;
            $auth_ids = null;
            $authors = Yii::$app->session->get('authors');

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$letter_id = $letter->createLetter()){
                    throw new Exception("Ошибка сохранения обращения", 500);
                }
                if ($author->validate()) {
                    if (!$auth_id = $author->createAuthor()){
                        throw new Exception("Ошибка сохранения текущего автора", 500);
                    }
                    if (!$this->linkRequestToAuthor($auth_id, $letter_id)){
                        throw new Exception("Ошибка привязки обращения к автору", 500);
                    }
                    $auth_ids[] = $auth_id;
                    $countAuthors++;
                }
                if (is_array($authors)) {
                    foreach ($authors as $aut) {
                        if (!$auth_id = $aut->createAuthor()){
                            throw new Exception("Ошибка сохранения соавтора", 500);
                        }
                        if (!$this->linkRequestToAuthor($auth_id, $letter_id)){
                            throw new Exception("Ошибка привязки обращения к автору", 500);
                        }
                        $auth_ids[] = $auth_id;
                        $countAuthors++;
                    }
                }
                if ($countAuthors) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Обращение успешно создано.');
                    foreach($auth_ids as $id){
                        $auth = Auth::findOne(['id' => $id]);
                        $request = Request::findOne(['id' => $letter_id]);
                        $activate = new ActivateForm;
                        $activate->email = $auth->email;
                        $activate->sendEmail('activateForRequest');
                        if ($countAuthors > 1){
                            $requestEmailType = 'requestGroup';
                        } else if (Yii::$app->user->id == $id){
                            $requestEmailType = 'requestUser';
                        } else {
                            $requestEmailType = 'requestOne';
                        }
                        $this->sendRequestEmail($requestEmailType, $auth, $request);
                    }
                    Yii::$app->session->setFlash('danger', 'На электронную почту была отправлена инструкция по дальнейшим действиям.');
                    return $this->redirect(['site/index']);
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        $radioArray = [
            'fio' => 'Фамилия, имя, отчество должностного лица',
            'position' => 'Должность должностного лица',
            'organization' => 'БУ ХМАО-Югры "Няганская городская поликлиника"',
        ];
        Yii::$app->session->remove('authors');
        if (Yii::$app->user->can('user')) {
            $auth = Auth::findIdentity(Yii::$app->user->id);
            $author->email = $auth->email;
            $author->lastname = $auth->profile->lastname;
            $author->firstname = $auth->profile->firstname;
            $author->middlename = $auth->profile->middlename;
            $author->organization = $auth->profile->organization;
            $author->phone = $auth->profile->phone;
        }
        $executiveArray = ArrayHelper::map(RequestExecutive::find()
        ->joinWith(['auth.profile'])
        ->orderBy('lastname')
        ->all(), 'auth.id', 'fioPosition');
        return $this->render('write', [
            'executiveArray' => $executiveArray,
            'model' => $author,
            'letter' => $letter,
            'radioArray' => $radioArray,
        ]);
    }



    public function actionGetExecutive() {
        $type = Yii::$app->request->post('type');
        $array = [];
        switch ($type) {
            case 'fio':
                $whom = RequestExecutive::find()->joinWith(['auth.profile'])->orderBy('lastname')->all();
                foreach ($whom as $element) {
                    $array[] = '<option value="' . $element->auth->id . '">' . $element->fioPosition . '</option>';
                }
                break;
            case 'position':
                $whom = RequestExecutive::find()->orderBy('position')->all();
                foreach ($whom as $element) {
                    $array[] = '<option value="' . $element->auth->id . '">' . $element->positionFio . '</option>';
                }
                break;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $array;
    }



    public function actionGetNextAuthor() {
        $model = new AuthorForm();
        if ($model->load(Yii::$app->request->post())) {
            $authors = Yii::$app->session->get('authors');
            $authors[] = $model;
            Yii::$app->session->set('authors', $authors);
            return '<li>' . $model->fio . '</li>';
        }
        return false;
    }



    private function linkRequestToAuthor($auth_id, $request_id) {
        if (RequestUser::findOne(['auth_id' => $auth_id, 'request_id' => $request_id])) {
            return true;
        }
        $model = new RequestUser;
        $model->auth_id = $auth_id;
        $model->request_id = $request_id;
        $model->active = (Yii::$app->user->id == $auth_id) ? RequestUser::STATUS_ACTIVE : RequestUser::STATUS_INACTIVE;
        if ($model->save()) {
            return $model->id;
        } else {
            $error = new Errors;
            $error->controller = Yii::$app->controller->id;
            $error->action = Yii::$app->controller->action->id;
            $error->doing = 'linkRequestToAuthor()';
            $error->error = $model->error;
            $error->save();
            return false;
        }
    }



    public function actionActive($id) {
        $model = RequestUser::find()
            ->where(['auth_id' => Yii::$app->user->id, 'request_id' => $id])
            ->one();
        if ($model) {
            $model->active = RequestUser::STATUS_ACTIVE;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Вы подписались под обращение. Теперь в случае ответа он будет продублирован на Вашу электронную почту.');
            } else {
                Yii::$app->session->setFlash('danger', 'Произошла ошибка. Пожалуйста, попробуйте позже.');
            }
        }
        return $this->redirect(['kabinet/index']);
    }



    protected function findModel($id) {
        if (($model = Request::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
    
    private function sendRequestEmail($html, $auth, $letter) {
        $res = Yii::$app->mailer->compose(['html' => $html], ['auth' => $auth, 'model' => $letter])
            ->setFrom(Yii::$app->params['noreplyEmail'])
            ->setTo($auth->email)
            ->setSubject("Создание обращения на сайте " . Yii::$app->params['siteCaption'])
            ->send();
            if ($res) {
                return true;
            } else {
                return false;
            }
    }
}
