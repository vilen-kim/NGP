<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\base\Exception;
use app\models\forms\AuthorForm;
use app\models\forms\AnswerForm;
use app\models\forms\RequestForm;
use app\models\Request;
use app\models\RequestExecutive;
use app\models\RequestUser;
use app\models\RequestSearch;
use app\models\Auth;
use kartik\mpdf\Pdf;


class RequestController extends \yii\web\Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                    [
                        'actions' => ['activate', 'answer', 'delete', 'resend', 'share', 'un-share'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'get-executive',
                            'get-next-author',
                            'get-pdf',
                            'create-request-and-authors'
                        ],
                        'allow' => true,
                        'roles' => ['?', '@'],
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
            'model'  => $model,
            'authors'=> $authors,
        ]);
    }



    /**
     * Удаление неактивного обращения у текущего пользователя
     * @param $id int - ид обращения
     */
    public function actionDelete($id) {
        $model = RequestUser::findOne([
            'request_id'=> $id,
            'auth_id'   => Yii::$app->user->id,
            'active'    => RequestUser::STATUS_INACTIVE,
        ]);
        if ($model && $model->delete()) {
            Yii::$app->session->setFlash('success', 'Обращение было успешно удалено');
        }
        $this->redirect(['kabinet/request']);
    }



    public function actionAnswer($id) {
        $request = $this->findModel($id);
        $user_id = Yii::$app->user->id;
        if (!RequestExecutive::findOne(['auth_id' => $user_id]) || $request->request_auth_id != $user_id){
            throw new \yii\web\ForbiddenHttpException('У вас нет права отвечать на обращения.');
            Yii::$app->end;
        }
        
        $answer = new AnswerForm;
        if ($answer->load(Yii::$app->request->post()) && $answer->createAnswer($request)) {
            foreach ($request->requestUsers as $user) {
                if ($user->active == RequestUser::STATUS_ACTIVE) {
                    $this->sendHaveAnswerEmail($request, $user->auth);
                }
            }
            Yii::$app->session->setFlash('success', 'Ваш ответ на обращение успешно сохранен.');
            return $this->redirect(['kabinet/request']);
        }

        $authors = null;
        foreach ($request->requestUsers as $user) {
            $authors .= $user->auth->fio;
            if ($user->active == RequestUser::STATUS_INACTIVE) {
                $authors .= ' (-)';
            }
            $authors .= '<br>';
        }

        return $this->render('answer', [
            'request' => $request,
            'answer' => $answer,
            'authors' => $authors,
        ]);
    }



    /**
     * Отображение обращения на странице общего просмотра
     * @param  $id int - идентификатор обращения
     * @param  $date date - на какую дату отображать обращения
     */
    public function actionShare($id = false, $date = false) {
        $user_id = Yii::$app->user->id;
        if ($id && RequestExecutive::findOne(['auth_id' => $user_id])) {
            $model = Request::findOne([
                'id'            => $id,
                'answer_auth_id'=> $user_id,
                'share'         => null
            ]);
            if ($model->answer_text) {
                try {
                    $this->createPdf($model);
                    $model->share = true;
                    $model->save();
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('danger', 'Произошла ошибка. Попробуйте позже.');   
                }
                Yii::$app->session->setFlash('success', 'Обращение успешно расшарено.');
            }
            return $this->redirect(['kabinet/request', 'type' => 1]);
        }
    }



    /**
     * Снятие обращения со страницы общего просмотра
     * @param  $id int - идентификатор обращения
     */
    public function actionUnShare($id) {
        $user_id = Yii::$app->user->id;
        if ($id && RequestExecutive::findOne(['auth_id' => $user_id])) {
            $model = Request::findOne([
                'id'            => $id,
                'answer_auth_id'=> $user_id,
                'share'         => true,
            ]);
            $model->share = null;
            if ($model->save()) {
                system("rm -rf pdf/$id.pdf");
                Yii::$app->session->setFlash('success', 'Обращение снято с общего просмотра.');
            } else {
                Yii::$app->session->setFlash('danger', 'Произошла ошибка. Попробуйте позже.');
            }
        }
        return $this->redirect(['kabinet/request', 'type' => 1]);
    }



    private function createPdf($model) {
        $i = Html::tag('i', 'Вопрос от ' . Yii::$app->formatter->asDate($model->request_created_at));
        $pHeader = Html::tag('p', $i, ['class' => 'small', 'style' => 'font-weight: bold']);
        $pContent = Html::tag('p', Html::encode($model->request_text), ['class' => 'text-justify']);
        $question = $pHeader . $pContent;

        $i = Html::tag('i', 'Ответ от ' . Yii::$app->formatter->asDate($model->answer_created_at));
        $pHeader = Html::tag('p', "$i", ['class' => 'small', 'style' => 'font-weight: bold']);
        $pContent = Html::tag('p', Html::encode($model->answer_text), ['class' => 'text-justify']);
        $answer = $pHeader . $pContent;

        $pdf = new Pdf([
            'content' => "$question<br><br>$answer",
            'filename' => "pdf/$model->id.pdf",
            'destination' => Pdf::DEST_FILE,
            'options' => [
                'title' => 'Ответы на обращения, затрагивающие интересы неопределенного круга лиц',
            ],
        ]);

        return $pdf->render();
    }



    /**
     * Перенаправление обращения другому должностному лицу
     */
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
        $this->redirect(['kabinet/request']);
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



    public function actionActivate($id) {
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
        return $this->redirect(['kabinet/request']);
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
        $priemAuth = Auth::findByEmail(Yii::$app->params['priemEmail']);
        $priemID = $priemAuth->id;

        if ($request->load(Yii::$app->request->post()) && $author->load(Yii::$app->request->post())) {
            $countAuthors = 0;
            $auth_ids = null;
            $authors = Yii::$app->session->get('authors');
            if ($author->validate()) {
                $authors[] = $author;
            } else if (!is_array($authors)) {
                return false;
            }

            // Если отправка на БУ, то выбираем пользователя с email priem@nyagangp.ru
            if (Yii::$app->request->post('typeExecutive') == 'organization'){
                $request->request_auth_id = $priemID;
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
