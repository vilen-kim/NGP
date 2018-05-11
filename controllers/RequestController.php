<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use app\models\forms\AuthorForm;
use app\models\RequestExecutive;

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
        $model = new AuthorForm();

        $executiveArray = ArrayHelper::map(RequestExecutive::find()
        ->joinWith(['auth.profile'])
        ->orderBy('lastname')
        ->all(), 'auth.id', 'fioPosition');
        return $this->render('write', [
            'executiveArray' => $executiveArray,
            'model' => $model,
        ]);
    }



    public function actionGetExecutive() {
        $type = Yii::$app->request->post('type');
        $array = [];
        switch ($type) {
            case 'fio':
                $whom = RequestExecutive::find()->joinWith(['auth.profile'])->orderBy('lastname')->all();
                foreach ($whom as $element) {
                    $array[] = "<option value=$element->id>$element->fioPosition</option>";
                }
                break;
            case 'position':
                $whom = RequestExecutive::find()->orderBy('position')->all();
                foreach ($whom as $element) {
                    $array[] = "<option value=$element->id>$element->positionFio</option>";
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
