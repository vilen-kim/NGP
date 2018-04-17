<?php

namespace app\controllers;

use Yii;
use app\models\Pages;
use app\models\PagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class PagesController extends Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete', 'view', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
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



    public function actionIndex($category_id = 1) {
        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $category_id);
        switch ($category_id) {
            case 1: $title = 'Страницы';
                break;
            case 2: $title = 'Новости';
                break;
            case 3: $title = 'Статьи';
                break;
            case 4: $title = 'Мероприятия';
                break;
        }
        if (isset($title)) {
            return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'category_id' => $category_id,
                    'title' => $title,
            ]);
        } else {
            return $this->redirect(['admin/index']);
        }
    }



    public function actionView($id) {
        $model = $this->findModel($id);
        switch ($model->category_id) {
            case 1: $type = 'Страницы';
                break;
            case 2: $type = 'Новости';
                break;
            case 3: $type = 'Статьи';
                break;
            case 4: $type = 'Мероприятия';
                break;
        }
        
        return $this->render('view', [
                'model' => $model,
                'type' => $type,
        ]);
    }



    public function actionCreate($category_id) {
        $model = new Pages();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Сохранено.');
                $this->redirect(Url::to(['admin/index']));
            } else {
                var_dump($model->errors);
            }
        }

        switch ($category_id) {
            case 1: $title = 'Создание страницы';
                $type = 'Страницы';
                break;
            case 2: $title = 'Создание новости';
                $type = 'Новости';
                break;
            case 3: $title = 'Создание статьи';
                $type = 'Статьи';
                break;
            case 4: $title = 'Создание мероприятия';
                $type = 'Мероприятия';
                break;
        }

        $model->category_id = $category_id;
        $model->auth_id = Yii::$app->user->id;
        return $this->render('create', [
                'model' => $model,
                'title' => $title,
                'type' => $type,
        ]);
    }



    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        switch ($model->category_id) {
            case 1: $type = 'Страницы';
                break;
            case 2: $type = 'Новости';
                break;
            case 3: $type = 'Статьи';
                break;
            case 4: $type = 'Мероприятия';
                break;
        }

        return $this->render('update', [
                'model' => $model,
                'type' => $type,
        ]);
    }



    public function actionDelete($id) {
        $model = $this->findModel($id);
        $category_id = 1;
        if ($model) {
            $category_id = $model->category_id;
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Страница была успешно удалена.');
            }
        }
        return $this->redirect(['pages/index', 'category_id' => $category_id]);
    }



    protected function findModel($id) {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
