<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use app\models\forms\AuthorForm;
use app\models\forms\AnswerForm;
use app\models\forms\RequestForm;
use app\models\Request;
use app\models\RequestExecutive;
use app\models\RequestUser;
use app\models\RequestSearch;
use app\models\Auth;

class RequestController extends \yii\web\Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                    [
                        'actions' => ['active', 'view', 'answer', 'delete', 'resend'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['info', 'share', 'get-executive', 'get-next-author', 'write', 'create-request-and-authors'],
                        'allow' => true,
                        'roles' => ['?', '@'],
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
        if (!Yii::$app->user->can('manager') &&
        !RequestUser::findOne(['request_id' => $id, 'auth_id' => Yii::$app->user->id, 'active' => RequestUser::STATUS_ACTIVE]) &&
        !Request::findOne(['id' => $id, 'request_auth_id' => Yii::$app->user->id])) {
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



    public function actionDelete($id) {
        $model = RequestUser::findOne(['request_id' => $id, 'auth_id' => Yii::$app->user->id, 'active' => RequestUser::STATUS_INACTIVE]);
        if ($model && $model->delete()) {
            Yii::$app->session->setFlash('success', 'Обращение было успешно удалено');
        }
        $this->redirect(['kabinet/index']);
    }



    public function actionInfo() {
        return $this->render('info');
    }



    public function actionWrite() {
        $author = new AuthorForm;
        $letter = new RequestForm;

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



    public function actionAnswer($id) {
        $request = $this->findModel($id);
        $answer = new AnswerForm;

        if ($answer->load(Yii::$app->request->post()) && $answer->createAnswer($request)) {
            foreach ($request->requestUsers as $user) {
                if ($user->active == RequestUser::STATUS_ACTIVE) {
                    $this->sendHaveAnswerEmail($request, $user->auth);
                }
            }
            Yii::$app->session->setFlash('success', 'Ваш ответ на обращение успешно сохранен.');
            return $this->redirect(['kabinet/index']);
        }

        $authors = null;
        foreach ($request->requestUsers as $user) {
            $authors .= $user->auth->fio;
            if ($user->active == RequestUser::STATUS_INACTIVE) {
                $authors .= ' (-)';
            }
            $authors .= '<br>';
        }
        $user_id = Yii::$app->user->id;
        if (RequestExecutive::findOne(['auth_id' => $user_id]) && $request->request_auth_id == $user_id) {
            return $this->render('answer', [
                'request' => $request,
                'answer' => $answer,
                'authors' => $authors,
            ]);
        } else {
            throw new \yii\web\ForbiddenHttpException('У вас нет прав доступа.');
        }
    }



    public function actionShare($id = false) {
        if ($id && RequestExecutive::findOne(['auth_id' => Yii::$app->user->id])){
            $model = Request::findOne(['id' => $id]);
            if ($model->answer_text){
                $model->share = true;
                if ($model->save()){
                    Yii::$app->session->setFlash('success', 'Обращение успешно расшарено.');
                } else {
                    Yii::$app->session->setFlash('danger', 'Произошла ошибка. Попробуйте позже.');
                }
                return $this->redirect(['kabinet/index']);
            }
        }
        
        $model = Request::find()->where(['share' => true])->orderBy(['request_created_at' => SORT_DESC])->all();
        return $this->render('share', [
            'model' => $model,
        ]);
    }



    public function actionResend() {
        $auth_id = Yii::$app->request->post('auth_id');
        $request_id = Yii::$app->request->post('request_id');
        $from = RequestExecutive::findOne(['auth_id' => Yii::$app->user->id]);
        $to = RequestExecutive::findOne(['auth_id' => $auth_id]);
        if ($from && $to) {
            $request = Request::findOne(['id' => $request_id]);
            $fio = $to->fioPosition;
            $prevFio = $from->fioPosition;
            if ($request) {
                $request->request_auth_id = $auth_id;
                if ($request->save()) {
                    Yii::$app->session->setFlash('success', "Обращение было перенаправлено на $fio");
                    $this->sendResendRequestEmail($request_id, $prevFio);
                }
            }
        }
        $this->redirect(['kabinet/index']);
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
            Yii::error('Ошибка привязки обращения к автору', 'requestUser_category');
            return false;
        }
    }



    public function actionActive($id) {
        $model = RequestUser::findOne(['auth_id' => Yii::$app->user->id, 'request_id' => $id]);
        if ($model) {
            $model->active = RequestUser::STATUS_ACTIVE;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Вы подписались под обращением. Теперь в случае ответа он будет продублирован на Вашу электронную почту.');
                if ($model->request->answer_text) {
                    $this->sendHaveAnswerEmail($model->request, $model->auth);
                }
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



    public function actionCreateRequestAndAuthors() {
        $author = new AuthorForm;
        $request = new RequestForm;

        if ($request->load(Yii::$app->request->post()) && $author->load(Yii::$app->request->post())) {
            $countAuthors = 0;
            $auth_ids = null;
            $authors = Yii::$app->session->get('authors');
            if ($author->validate()) {
                $authors[] = $author;
            } else if (!is_array($authors)) {
                return false;
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$request_id = $request->createRequest()) {
                    throw new Exception("Во время сохранения обращения возникла ошибка.", 500);
                }
                foreach ($authors as $aut) {
                    if (!$auth_id = $aut->createAuthor()) {
                        throw new Exception("Во время регистрации автора возникла ошибка", 500);
                    }
                    if (!$this->linkRequestToAuthor($auth_id, $request_id)) {
                        throw new Exception("Ошибка привязки обращения к автору", 500);
                    }
                    $auth_ids[] = $auth_id;
                    $countAuthors++;
                }
                $transaction->commit();
                foreach ($auth_ids as $id) {
                    $this->sendActivateEmail($id);
                    $this->sendRequestEmail($id, $countAuthors, $request_id);
                }
                $this->sendHaveRequestEmail($request_id);
                Yii::$app->session->setFlash('success', 'Обращение успешно создано. На электронную почту была отправлена инструкция по дальнейшим действиям.');
                return $this->redirect(['site/index']);
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }



    private function sendActivateEmail($id) {
        if ($auth = Auth::findOne(['status' => Auth::STATUS_INACTIVE, 'id' => $id])) {
            $auth->generatePasswordResetToken();
            if (!$auth->save()) {
                Yii::error('Ошибка сохранения passwordresettoken в auth', 'auth_category');
                return false;
            }
            if (!$res = Yii::$app->mailer->compose(['html' => 'activateForRequest'], ['auth' => $auth])
            ->setFrom(Yii::$app->params['noreplyEmail'])
            ->setTo($auth->email)
            ->setSubject("Активация учетной записи на сайте " . Yii::$app->params['siteCaption'])
            ->send()) {
                Yii::warning('Ошибка отправки письма активации activateForRequest', 'email_category');
                return false;
            }
            return true;
        }
    }



    private function sendRequestEmail($id, $count, $request_id) {
        $auth = Auth::findOne(['id' => $id]);
        $request = Request::findOne(['id' => $request_id]);
        $type = 'requestGuest';
        if (Yii::$app->user->id == $id) {
            $type = 'requestUser';
        } else if ($count > 1) {
            $type = 'requestGroup';
        }
        if (!$res = Yii::$app->mailer->compose(['html' => $type], ['auth' => $auth, 'request' => $request])
        ->setFrom(Yii::$app->params['noreplyEmail'])
        ->setTo($auth->email)
        ->setSubject("Создание обращения на сайте " . Yii::$app->params['siteCaption'])
        ->send()) {
            Yii::warning('Ошибка отправки письма о создании обращения', 'email_category');
            return false;
        }
        return true;
    }



    private function sendHaveRequestEmail($request_id) {
        $request = Request::findOne(['id' => $request_id]);
        if (!$res = Yii::$app->mailer->compose(['html' => 'haveRequest'], ['request' => $request])
        ->setFrom(Yii::$app->params['noreplyEmail'])
        ->setTo($request->requestAuth->email)
        ->setSubject("Вам обращение с сайта " . Yii::$app->params['siteCaption'])
        ->send()) {
            Yii::warning('Ошибка отправки письма о поступлении обращения', 'email_category');
            return false;
        }
        return true;
    }



    private function sendResendRequestEmail($request_id, $fio) {
        $request = Request::findOne(['id' => $request_id]);
        if (!$res = Yii::$app->mailer->compose(['html' => 'haveResendRequest'], ['request' => $request, 'fio' => $fio])
        ->setFrom(Yii::$app->params['noreplyEmail'])
        ->setTo($request->requestAuth->email)
        ->setSubject("Вам перенаправили обращение с сайта " . Yii::$app->params['siteCaption'])
        ->send()) {
            Yii::warning('Ошибка отправки письма о перенаправлении обращения', 'email_category');
            return false;
        }
        return true;
    }



    private function sendHaveAnswerEmail($request, $auth) {
        if (!$res = Yii::$app->mailer->compose(['html' => 'haveAnswer'], ['request' => $request, 'auth' => $auth])
        ->setFrom(Yii::$app->params['noreplyEmail'])
        ->setTo($auth->email)
        ->setSubject("Ответ на Ваше обращение с сайта " . Yii::$app->params['siteCaption'])
        ->send()) {
            Yii::warning('Ошибка отправки письма о поступлении ответа на обращение', 'email_category');
            return false;
        }
        return true;
    }
}
