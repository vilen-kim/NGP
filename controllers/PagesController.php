<?php

namespace app\controllers;

use Yii;
use app\models\Pages;
use app\models\PagesSearch;
use app\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class PagesController extends Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['editor'],
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



    public function actionIndex() {
        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }



    public function actionCreate() {
        $model = new Pages();

        if ($model->load(Yii::$app->request->post())) {
            $model->auth_id = Yii::$app->user->id;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Страница успешно сохранена.');
            } else {
                Yii::$app->session->setFlash('danger', 'При сохранении страницы возникла ошибка.');
            }
            return $this->redirect(Url::to(['view', 'id' => $model->id]));
        }

        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'caption');
        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }



    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->auth_id = Yii::$app->user->id;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Страница успешно сохранена.');
            } else {
                Yii::$app->session->setFlash('danger', 'При сохранении возникла ошибка.');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'caption');
        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }



    public function actionDelete($id) {
        $model = $this->findModel($id);
        $caption = $model->caption;
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', "Страница '$caption' была успешно удалена.");
        }
        return $this->redirect('index');
    }



    protected function findModel($id) {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
