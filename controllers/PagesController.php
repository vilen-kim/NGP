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
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {
                            switch (Yii::$app->request->get('category_id')) {
                                case 1: return Yii::$app->user->can('page_' . $action->id);
                                case 2:
                                case 3:
                                case 4: return Yii::$app->user->can('news_' . $action->id);
                            }
                        }
                    ],
                    [
                        'actions' => ['view', 'update', 'delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {
                            $id = Yii::$app->request->get('id');
                            $model = $this->findModel($id);
                            switch ($model->category_id) {
                                case 1: return Yii::$app->user->can('page_' . $action->id);
                                case 2:
                                case 3:
                                case 4: return Yii::$app->user->can('news_' . $action->id);
                            }
                        }
                    ]
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
        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'category_id' => $category_id,
                'tt' => $this->getTitleAndType($category_id),
        ]);
    }



    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->render('view', [
                'model' => $model,
                'tt' => $this->getTitleAndType($model->category_id),
        ]);
    }



    public function actionCreate($category_id = 1) {
        $model = new Pages();

        if ($model->load(Yii::$app->request->post())) {
            $can = false;
            switch ($model->category_id) {
                case 1: $can = Yii::$app->user->can('page_create');
                    break;
                case 2:
                case 3:
                case 4: $can = Yii::$app->user->can('news_create');
                    break;
            };
            if ($can && $model->save()) {
                Yii::$app->session->setFlash('success', 'Сохранено.');
            } else {
                Yii::$app->session->setFlash('danger', 'Возникла ошибка.');
            }
            $this->redirect(Url::to(['pages/index', 'category_id' => $model->category_id]));
        }

        $model->category_id = $category_id;
        $model->auth_id = Yii::$app->user->id;
        return $this->render('create', [
                'model' => $model,
                'tt' => $this->getTitleAndType($category_id),
        ]);
    }



    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $can = false;
            switch ($model->category_id) {
                case 1: $can = Yii::$app->user->can('page_update');
                    break;
                case 2:
                case 3:
                case 4: $can = Yii::$app->user->can('news_update');
                    break;
            };
            $model->auth_id = Yii::$app->user->id;
            if ($can && $model->save()) {
                Yii::$app->session->setFlash('success', 'Сохранено.');
            } else {
                Yii::$app->session->setFlash('danger', 'Возникла ошибка.');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                'model' => $model,
                'tt' => $this->getTitleAndType($model->category_id),
        ]);
    }



    public function actionDelete($id) {
        $model = $this->findModel($id);
        $category_id = $model->category_id;
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Страница была успешно удалена.');
        }
        return $this->redirect(['pages/index', 'category_id' => $category_id]);
    }



    protected function findModel($id) {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }



    protected function getTitleAndType($category_id) {
        $array = null;
        switch ($category_id) {
            case 1:
                $array['title'] = 'Создание страницы';
                $array['type'] = 'Страницы';
                break;
            case 2:
                $array['title'] = 'Создание новости';
                $array['type'] = 'Новости';
                break;
            case 3:
                $array['title'] = 'Создание статьи';
                $array['type'] = 'Статьи';
                break;
            case 4:
                $array['title'] = 'Создание мероприятия';
                $array['type'] = 'Мероприятия';
                break;
        }
        return $array;
    }
}
