<?php

namespace app\controllers;

use Yii;
use app\models\Pages;
use app\models\Banners;
use app\components\News;
use app\components\MenuItems;
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
        $lastID = Pages::find()->select('id')->where(['in', 'category_id', [2, 3, 4]])->orderBy(['id' => SORT_DESC])->limit(5)->all();
        $items = null;
        foreach ($lastID as $id) {
            $news[] = new News($id->id, 600);
        }
        $banners = Banners::findAll(['main' => true]);
        return $this->render('index', [
            'news' => $news,
            'banners' => $banners,
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



    public function actionMenu() {
        $menu = new MenuItems();
        return $this->render('menu', [
            'menu' => $menu,
        ]);
    }



    public function actionNews() {
        $news = Pages::find()->select(['id', 'caption'])->where(['in', 'category_id', [2, 3, 4]])->orderBy(['id' => SORT_DESC])->asArray()->all();
        return $this->render('news', [
            'news' => $news,
        ]);
    }



    public function actionBanners() {
        $banners = Banners::find()->all();
        return $this->render('banners', ['banners' => $banners]);
    }



    public function actionEyeOn() {
        $session = Yii::$app->session;
        $session->open();
        $session->set('eye', True);
        return true;
    }



    public function actionEyeOff() {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('eye');
        return true;
    }



    protected function findModel($id) {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }

}
