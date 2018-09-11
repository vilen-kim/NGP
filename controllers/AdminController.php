<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\Auth;
use app\models\Pages;
use app\models\Menu;
use app\models\Request;
use app\models\Banners;

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
        $count['banners'] = Banners::find()->count();
        $count['wall'] = Pages::find()->where(['is not', 'vk_id', null])->count();
        return $this->render('index', ['count' => $count]);
    }



    public function actionGetWall() {
        $photoSizeArray = [
            //'photo_2560',
            //'photo_1280',
            'photo_807',
            'photo_604',
            'photo_130',
            'photo_75',
        ];
        $owner_id = Yii::$app->vk->owner_id;
        $count = 0;
        $haveErrors = null;
        $walls = Yii::$app->vk->api('wall.get', [
            'owner_id' => $owner_id,
            'count' => 10,
            'v' => '5.75',
        ]);
        $rev_walls = array_reverse($walls['response']['items']);
        foreach ($rev_walls as $item) {
            $id = $item['id'];
            if (!Pages::findOne(['vk_id' => $id])) {
                $page = new Pages;
                $page->text = nl2br($item['text'], false);
                $caption = stristr($page->text, '<br>', true);
                $page->caption = ($caption) ? $caption : 'Запись в ВК';
                $page->category_id = 2;
                $page->vk_id = $item['id'];
                $page->auth_id = Yii::$app->user->id;

                if (isset($item['attachments'])) {
                    foreach ($item['attachments'] as $attach) {
                        switch ($attach['type']) {
                            case 'photo':
                                foreach ($photoSizeArray as $size) {
                                    if (isset($attach['photo'][$size])) {
                                        $page->text .= '<p>' . Html::img($attach['photo'][$size]) . '</p>';
                                        break;
                                    }
                                }
                                break;
                            case 'link':
                                $url = $attach['link']['url'];
                                foreach ($photoSizeArray as $size) {
                                    if (isset($attach['link']['photo'][$size])) {
                                        $img = Html::img($attach['link']['photo'][$size]);
                                        $page->text .= '<p>' . Html::a($img, $url) . '</p>';
                                        break;
                                    }
                                }
                                break;
                        }
                    }
                }

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
