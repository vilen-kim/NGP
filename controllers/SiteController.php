<?php

namespace app\controllers;

use app\models\Pages;

class SiteController extends \yii\web\Controller {



    public function actionIndex() {
        return $this->render('index');
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
