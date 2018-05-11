<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\models\forms\AuthorForm;
use app\models\forms\ActivateForm;
use app\models\RequestExecutive;
use app\models\Request;
use app\models\Auth;
use app\models\UserProfile;

class RequestController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'], // администратор
                    ],
                    [
                        'actions' => ['info', 'write', 'get-next-author', 'get-whom'],
                        'allow' => true, // все
                        'roles' => ['?', '@'],
                    ]
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

    public function actionInfo() {
        return $this->render('info');
    }

    public function actionWrite() {
        $model = new AuthorForm;
        $letter = new Request;

        if ($letter->load(Yii::$app->request->post())) {
            $authors = Yii::$app->session->get('authors');
            if (!$authors) {
                Yii::$app->session->setFlash('danger', 'Укажите автора(ов) обращения');
            } else {
                foreach ($authors as $author) {
                    if (!Auth::findByEmail($author->email)) {
                        $transaction = Yii::$app->db->beginTransaction();
                        try {
                            $auth = new Auth;
                            $auth->email = $author->email;
                            $auth->status = Auth::STATUS_INACTIVE;
                            $auth->setPassword(Yii::$app->params['genPass']);
                            $auth->generateAuthKey();
                            if (!$auth->save()) {
                                throw new Exception("Ошибка сохранения учетной записи");
                            }

                            $profile = new UserProfile;
                            $profile->auth_id = $auth->id;
                            $profile->firstname = $author->firstname;
                            $profile->lastname = $author->lastname;
                            $profile->middlename = $author->middlename;
                            $profile->phone = $author->phone;
                            $profile->organization = $author->organization;
                            if (!$profile->save()) {
                                throw new Exception("Ошибка сохранения профиля");
                            }

                            $role = Yii::$app->authManager->getRole('user');
                            Yii::$app->authManager->assign($role, $auth->id);
                            $transaction->commit();

                            $activate = new ActivateForm();
                            $activate->email = $auth->email;
                            $activate->sendEmail();
                        } catch (\Exception $e) {
                            $transaction->rollBack();
                            throw $e;
                        }
                    }
                }
                Yii::$app->end();
            }
        }

        $radioArray = [
            'fio' => 'Фамилия, имя, отчество должностного лица',
            'position' => 'Должность должностного лица',
            'organization' => 'БУ ХМАО-Югры "Няганская городская поликлиника"',
        ];
        Yii::$app->session->remove('authors');
        $executiveArray = ArrayHelper::map(RequestExecutive::find()
                    ->joinWith(['auth.profile'])
                    ->orderBy('lastname')
                    ->all(), 'auth.id', 'fioPosition');
        return $this->render('write', [
                'executiveArray' => $executiveArray,
                'model' => $model,
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

    protected function findModel($id) {
        if (($model = RequestWhom::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }

}
