<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\jui\Accordion;
use yii\widgets\DetailView;
use app\models\RequestWhom;
use app\models\RequestWhomSearch;
use app\models\forms\WhomForm;
use app\models\forms\AuthorForm;

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
                        'actions' => ['info', 'write'],
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
        $model = new AuthorForm();



        $whomArray = ArrayHelper::map(RequestWhom::find()->orderBy('lastname')->all(), 'id', 'fioPosition');
        return $this->render('write', [
            'whomArray' => $whomArray,
            'model' => $model,
        ]);
    }



    public function actionWhom() {
        $searchModel = new RequestWhomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('whom', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionGetWhom() {
        $type = Yii::$app->request->post('type');
        $array = [];
        switch ($type) {
            case 'fio':
                $whom = RequestWhom::find()->orderBy('lastname')->all();
                foreach ($whom as $element) {
                    $array[] = "<option value=$element->id>$element->fioPosition</option>";
                }
                break;
            case 'position':
                $whom = RequestWhom::find()->orderBy('position')->all();
                foreach ($whom as $element) {
                    $array[] = "<option value=$element->id>$element->positionFio</option>";
                }
                break;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $array;
    }



    public function actionCreate() {
        $model = new WhomForm();

        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            Yii::$app->session->setFlash('success', 'Учетная запись была успешно создана.');
            return $this->redirect('whom');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    public function actionUpdate($id) {
        if ($whom = $this->findModel($id)) {
            $model = new WhomForm;
            $model->email = $whom->email;
            $model->phone = $whom->phone;
            $model->firstname = $whom->firstname;
            $model->lastname = $whom->lastname;
            $model->middlename = $whom->middlename;
            $model->position = $whom->position;
            $model->organization = $whom->organization;

            if ($model->load(Yii::$app->request->post()) && ($whom = $model->update($whom))) {
                Yii::$app->session->setFlash('success', "Запись '$whom->fio' была успешно изменена.");
                return $this->redirect('whom');
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }



    public function actionDelete($id) {
        if ($model = $this->findModel($id)) {
            $fio = $model->fio;
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', "Учетная запись '$fio' была успешно удалена.");
            }
        }
        return $this->redirect('whom');
    }



    public function actionView($id) {
        if ($whom = $this->findModel($id)) {
            return $this->render('view', [
                'model' => $whom,
            ]);
        }
    }



    public function actionGetNextAuthor() {
        $model = new AuthorForm();
        if ($model->load(Yii::$app->request->post())) {
            $authors = Yii::$app->session->get('authors');
            $authors[] = $model;
            Yii::$app->session->set('authors', $authors);
            return '<div style="margin-bottom: 40px;">' .
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'fio',
                            'email:email',
                            'organization',
                            'phone',
                        ],
                        'template' => '<tr><td{captionOptions}>{label}</td><td{contentOptions}>{value}</td></tr>',
                    ]) .
                    '</div>';
        }
    }



    protected function findModel($id) {
        if (($model = RequestWhom::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
