<?php

namespace app\controllers;

use Yii;
use app\models\Menu;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use phpQuery;
use yii\jui\Sortable;
use yii\web\Response;
use app\models\Pages;

class MenuController extends Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manager'],
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
        $array = null;
        $parents = Menu::find()->where(['parent_id' => 0])->orderBy('position')->all();
        foreach ($parents as $par) {
            $array[] = "<span data-id='$par->id'>$par->caption</span>";
            $subMenu = Menu::find()->where(['parent_id' => $par->id])->orderBy('position')->all();
            if (count($subMenu)) {
                $elements = null;
                foreach ($subMenu as $sub) {
                    $elements[] = "<span data-id='$sub->id'>$sub->caption</span>";
                }
                $array[] = $elements;
            }
        }

        return $this->render('index', [
            'array' => $array,
        ]);
    }



    public function actionSave() {
        $arr = Yii::$app->request->post('arr');
        foreach ($arr as $element){
            $array = explode(';', $element);
            $model = Menu::findOne(['id' => $array[0]]);
            $model->parent_id = $array[1];
            $model->position = $array[2];
            $model->save();
        }
        Yii::$app->session->setFlash('success', 'Порядок элементов массива был успешно сохранен.');
        return $this->redirect('index');
    }



    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }



    public function actionCreate() {
        $model = new Menu();
        $parents = ['0' => 'Укажите меню-родителя в случае создания подменю'] +
        ArrayHelper::map(Menu::findAll(['parent_id' => 0]), 'id', 'caption');
        $pages = Pages::find()->select(['id as value', 'caption as label', 'caption as name'])->asArray()->all();
        $anchors = ['0' => 'Укажите якорь при необходимости'];

        if ($model->load(Yii::$app->request->post())) {
            $lastPosition = Menu::find()->where(['parent_id' => $model->parent_id])->orderBy(['position' => SORT_DESC])->asArray()->one()['position'];
            $model->position = $lastPosition + 1;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Элемент меню успешно создан.');
                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('danger', 'При создании элемента меню произошла ошибка.');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'parents' => $parents,
            'pages' => $pages,
            'anchors' => $anchors,
        ]);
    }



    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $parents = ['0' => 'Укажите родителя в случае создания подменю'] +
        ArrayHelper::map(Menu::findAll(['parent_id' => 0]), 'id', 'caption');
        $pages = ArrayHelper::map(Pages::find()->select(['id', 'caption'])->all(), 'id', 'caption');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Элемент меню успешно создан.');
            return $this->redirect('index');
        } else {
            Yii::$app->session->setFlash('danger', 'При создании элемента меню произошла ошибка.');
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



    public function actionGetAnchors() {
        $id = Yii::$app->request->post('id');
        if ($page = Pages::findOne(['id' => $id])) {
            $text = $page->text;
            $document = phpQuery::newDocumentHTML($text);
            $anchors = null;
            foreach ($document->find('a[name]') as $element) {
                $anchors[] = $element->getAttribute('name');
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $anchors;
        }
        return false;
    }



    protected function findModel($id) {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }
}
