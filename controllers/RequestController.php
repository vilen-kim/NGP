<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\models\forms\AuthorForm;
use app\models\forms\LetterForm;
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
            $haveAuthor = false;
            $authors = Yii::$app->session->get('authors');

            $transaction = Yii::$app->db->beginTransaction();
            $letter_id = $letter->createLetter();
            if (!is_numeric($letter_id)) {
                return var_dump($letter_id);
            }
            if ($author->validate()) {
                $auth_id = $author->createAuthor();
                if (!is_numeric($auth_id)) {
                    return var_dump($auth_id);
                }
                $link_id = $this->linkRequestToAuthor($auth_id, $letter_id);
                if (!is_numeric($link_id)) {
                    return var_dump($link_id);
                }
                $haveAuthor = true;
            }
            if (is_array($authors)) {
                foreach ($authors as $aut) {
                    $auth_id = $aut->createAuthor();
                    if (!is_numeric($auth_id)) {
                        return var_dump($auth_id);
                    }
                    $link_id = $this->linkRequestToAuthor($auth_id, $letter_id);
                    if (!is_numeric($link_id)) {
                        return var_dump($link_id);
                    }
                    $haveAuthor = true;
                }
            }
            if ($haveAuthor) {
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Обращение ожидает подтверждения в личном кабинете каждого автора/соавтора');
                return $this->redirect(['site/index']);
            } else {
                return false;
            }
            $transaction->rollBack();
            return 'Были какие-то ошибки';
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
    }



    private function linkRequestToAuthor($auth_id, $request_id) {
        if (RequestUser::findOne(['auth_id' => $auth_id, 'request_id' => $request_id])) {
            return 0;
        }
        $model = new RequestUser;
        $model->auth_id = $auth_id;
        $model->request_id = $request_id;
        $model->active = RequestUser::STATUS_INACTIVE;
        if (!$model->save()) {
            return $model->errors;
        } else {
            return $model->id;
        }
    }



    public function actionActive($id) {
        $model = RequestUser::find()
            ->where(['auth_id' => Yii::$app->user->id, 'id' => $id])
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
}
