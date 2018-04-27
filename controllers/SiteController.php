<?php

namespace app\controllers;

use app\models\Pages;

class SiteController extends \yii\web\Controller {



    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }



    public function actionIndex() {
        $newsCount = Pages::find()->where(['in', 'category_id', [2,3,4]])->count();
        return $this->render('index', [
            'newsCount' => $newsCount,
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
