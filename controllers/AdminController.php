<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use phpQuery;
use app\models\Auth;
use app\models\Pages;
use app\models\Menu;
use app\models\Request;

class AdminController extends \yii\web\Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'manager', 'editor'],
                    ],
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



    public function actionIndex() {
        $count = null;
        $count['users'] = Auth::find()->count();
        $count['menu'] = Menu::find()->count();
        $count['pages'] = Pages::find()->count();
        $count['requests'] = Request::find()->count();
        $count['wall'] = Pages::find()->where(['is not', 'vk_id', null])->count();
        return $this->render('index', ['count' => $count]);
    }



    public function actionGetWall() {
        $owner_id = Yii::$app->vk->owner_id;
        $count = 0;
        $haveErrors = null;
        $walls = Yii::$app->vk->api('wall.get', [
            'owner_id' => $owner_id,
            'count' => 10,
            'v' => '5.75',
        ]);
        foreach($walls['response']['items'] as $item){
            $id = $item['id'];
            if (!Pages::findOne(['vk_id' => $id])) {
                $page = new Pages;
                $page->caption = 'Запись в ВК';
                $page->text = '<p>' . str_replace("\r\n", '</p><p>', $item['text']) . '</p>';
                $page->category_id = 2;
                $page->vk_id = $item['id'];
                $page->auth_id = Yii::$app->user->id;
                if (!$page->save()) {
                    $haveErrors = true;
                } else {
                    $count++;
                }
            }
        }
        if ($count) {
            Yii::$app->session->setFlash('success', "Загружено $count записей со стены в ВК.");
        } else if ($haveErrors && $count) {
            Yii::$app->session->setFlash('warning', "В процессе загрузки были ошибки. Загружено $count записей со стены в ВК.");
        } else if ($haveErrors && !$count) {
            Yii::$app->session->setFlash('danger', "В процессе загрузки были ошибки. Записи не загружены.");
        }
        return $this->redirect(['admin/index']);
    }
}
