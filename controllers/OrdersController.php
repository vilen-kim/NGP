<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use app\models\Orders;
use app\models\OrdersPage;
use app\models\UploadFile;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class OrdersController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['page', 'index'],
                        'allow' => true,
                        'roles' => ['employee'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete', 'update-page'],
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    Yii::$app->session->setFlash('danger', "У вас нет доступа к странице $action->id");
                    if (!Yii::$app->user->isGuest) {
                        return $this->redirect(['kabinet/index']);
                    } else {
                        return $this->redirect(['site/index']);
                    }
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


    public function actionPage()
    {
        $model = OrdersPage::find()->one();
        return $this->render('page', [
            'model' => $model,
        ]);
    }


    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Orders::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $model = new UploadFile;
        $model->isArchive = false;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post('UploadFile');
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->caption = $post['caption'];
            $model->number = $post['number'];
            $model->date = $post['date'];
            if ($newFile = $model->upload()) {
                $order = new Orders;
                $order->file = '/' . $newFile;
                $order->caption = $model->caption;
                $order->number = $model->number;
                $order->date = $model->date;
                $order->isArchive = 0;
                if ($order->save()) {
                    Yii::$app->session->setFlash('success', 'Приказ был успешно добавлен.');
                    return $this->redirect(['orders/index']);
                } else {
                    Yii::$app->session->setFlash('danger', 'При добавлении приказа произошла ошибка.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (unlink(Yii::$app->basePath . '/web/' . $model->file)) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Приказ был успешно удален.');
        } else {
            Yii::$app->session->setFlash('danger', 'Ошибка удаления приказа.');
        }
        return $this->redirect(['index']);
    }


    public function actionUpdatePage() {
        $model = OrdersPage::find()->one();
        if (!$model) {
            $model = new OrdersPage;
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Страница успешно сохранена.');
            } else {
                Yii::$app->session->setFlash('danger', 'При сохранении страницы возникла ошибка.');
            }
            return $this->redirect(Url::to(['page']));
        }

        return $this->render('updatePage', [
            'model' => $model,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
