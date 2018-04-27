<?php

namespace app\controllers;

use Yii;
use app\models\Menu;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Pages;

class MenuController extends Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['menu'],
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
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find(),
        ]);
        $array = null;
        $parents = Menu::find()->where(['parent_id' => 0])->orderBy('position')->all();
        foreach ($parents as $par) {
            $array[] = [
                'link' => Html::a($par->caption, ['site/show', 'id' => $par->page_id, '#' => $par->anchor]),
                'type' => 'menu',
            ];
            $subMenu = Menu::find()->where(['parent_id' => $par->id])->orderBy('position')->all();
            foreach ($subMenu as $sub) {
                $array[] = [
                    'link' => Html::a($sub->caption, ['site/show', 'id' => $par->page_id, '#' => $sub->anchor]),
                    'type' => 'submenu',
                ];
            }
        }

        return $this->render('index', [
                'array' => $array,
                'dataProvider' => $dataProvider,
        ]);
    }



    public function actionView($id) {
        return $this->render('view', [
                'model' => $this->findModel($id),
        ]);
    }



    public function actionCreate() {
        $model = new Menu();
        $parents = ['0' => 'Укажите родителя в случае создания подменю'] +
            ArrayHelper::map(Menu::findAll(['parent_id' => 0]), 'id', 'caption');
        $pages = ArrayHelper::map(Pages::find()->select(['id', 'caption'])->all(), 'id', 'caption');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['menu/index']);
        }

        return $this->render('create', [
                'model' => $model,
                'parents' => $parents,
                'pages' => $pages,
        ]);
    }



    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $parents = ['0' => 'Укажите родителя в случае создания подменю'] +
            ArrayHelper::map(Menu::findAll(['parent_id' => 0]), 'id', 'caption');
        $pages = ArrayHelper::map(Pages::find()->select(['id', 'caption'])->all(), 'id', 'caption');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['menu/index']);
        }

        return $this->render('update', [
                'model' => $model,
                'parents' => $parents,
                'pages' => $pages,
        ]);
    }



    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['menu/index']);
    }



    protected function findModel($id) {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
