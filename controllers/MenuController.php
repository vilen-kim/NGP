<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
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
                'denyCallback' => function($rule, $action){
                    Yii::$app->session->setFlash('danger', "У вас нет доступа к странице $action->id");
                    return $this->redirect(['kabinet/index']);
                }
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
        $array = [];
        $cnt = 0;
        $parents = Menu::find()->where(['parent_id' => 0])->orderBy('position')->all();
        if (count($parents)) {
            foreach ($parents as $par) {
                $array[$cnt] = "<span data-id='$par->id'>$par->caption</span>" .
                Html::a("<span class='glyphicon glyphicon-trash pull-right hidden'></span>", ['menu/delete', 'id' => $par->id], [
                    'data' => [
                        'method' => 'post',
                        'confirm' => 'Вы уверены что хотите удалить это меню? Все подменю также будут удалены.',
                    ]
                ]) .
                Html::a("<span class='glyphicon glyphicon-pencil pull-right hidden' style='margin-right: 5px;'></span>", ['menu/update', 'id' => $par->id]);

                $subMenu = Menu::find()->where(['parent_id' => $par->id])->orderBy('position')->all();
                $elements = [];
                if (count($subMenu)) {
                    foreach ($subMenu as $sub) {
                        $elements[] = "<span data-id='$sub->id'>$sub->caption</span>" .
                        Html::a("<span class='glyphicon glyphicon-trash pull-right hidden'></span>", ['menu/delete', 'id' => $sub->id], [
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Вы уверены что хотите удалить это подменю?',
                            ]
                        ]) .
                        Html::a("<span class='glyphicon glyphicon-pencil pull-right hidden' style='margin-right: 5px;'></span>", ['menu/update', 'id' => $sub->id]);
                    }
                }
                $array[$cnt] .= Sortable::widget([
                    'items' => $elements,
                    'options' => [
                        'class' => 'subMenu',
                        'style' => [
                            'padding-top' => '5px',
                        ],
                    ],
                    'itemOptions' => [
                        'tag' => 'div',
                        'style' => [
                            'padding' => '5px',
                            'font-weight' => 'normal',
                            'font-size' => 'medium',
                            'margin-top' => '5px',
                        ],
                    ],
                    'clientOptions' => [
                        'cursor' => 'move',
                        'placeholder' => 'ui-state-highlight',
                        'connectWith' => '.subMenu',
                    ],
                ]);
                $cnt++;
            }
        }

        return $this->render('index', [
            'array' => $array,
        ]);
    }



    public function actionSave() {
        $arr = Yii::$app->request->post('arr');
        foreach ($arr as $element) {
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
        $parents = ['0' => 'Укажите меню-родителя в случае создания подменю'] +
        ArrayHelper::map(Menu::findAll(['parent_id' => 0]), 'id', 'caption');
        $pages = Pages::find()->select(['id as value', 'caption as label', 'caption as name'])->asArray()->all();
        $anchors = ['0' => 'Укажите якорь при необходимости'];

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Элемент меню успешно обновлен.');
                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('danger', 'При обновлении элемента меню произошла ошибка.');
                echo '<pre>';
                var_dump($model->errors);
                echo '</pre>';
            }
        }

        return $this->render('update', [
            'model' => $model,
            'parents' => $parents,
            'pages' => $pages,
            'anchors' => $anchors,
        ]);
    }



    public function actionDelete($id) {
        if ($model = $this->findModel($id)) {
            $subMenu = Menu::find()->where(['parent_id' => $model->id])->all();
            foreach ($subMenu as $menu) {
                $menu->delete();
            }
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Элемент меню успешно удален.');
            } else {
                Yii::$app->session->setFlash('danger', 'Во время удаления меню произошла ошибка.');
            }
        }
        return $this->redirect(['menu/index']);
    }



    public function actionGetAnchors() {
        $id = Yii::$app->request->post('id');
        if ($page = Pages::findOne(['id' => $id])) {
            $document = phpQuery::newDocumentHTML($page->text);
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
