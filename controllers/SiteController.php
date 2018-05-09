<?php

namespace app\controllers;

use Yii;
use app\models\Pages;
use app\components\NewsWidget;

class SiteController extends \yii\web\Controller {



    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }



    public function actionIndex() {
        $all = Pages::find()->where(['in', 'category_id', [2, 3, 4]])->count();
        $count = min($all, 3);
        $remain = $all - $count;
        return $this->render('index', [
            'count' => $count,
            'remain' => $remain,
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



    public function actionLoadNews() {
        $loaded = Yii::$app->request->post('loaded');
        $all = Pages::find()->where(['in', 'category_id', [2, 3, 4]])->count();
        $count = min($all - $loaded, 3);
        $result = null;
        for ($i = $loaded; $i < $loaded + $count; $i++) {
            $result .= NewsWidget::widget(['num' => $i]);
        }
        return $result;
    }



    protected function findModel($id) {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
