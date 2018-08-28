<?php

namespace app\controllers;

use app\models\Pages;
use app\components\News;
use yii\web\NotFoundHttpException;

class SiteController extends \yii\web\Controller {



    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }



    public function actionIndex() {
        $lastNews = new News(0, 200);
        return $this->render('index', [
            'news' => $lastNews,
        ]);
    }



    public function actionPhone() {
        return $this->render('phone');
    }



    public function actionCreateRequest() {
        $all = Pages::find()->where(['in', 'category_id', [2, 3, 4]])->count();
        $count = min($all, 3);
        $remain = $all - $count;
        return $this->render('index', [
            'count' => $count,
            'remain' => $remain,
        ]);
    }



    public function actionShow($id) {
        return $this->render('show', [
            'model' => $this->findModel($id),
        ]);
    }



    protected function findModel($id) {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
