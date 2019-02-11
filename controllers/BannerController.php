<?php

namespace app\controllers;

use Yii;
use app\models\Banners;
use app\models\UploadImage;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;



class BannerController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                ],
                'denyCallback' => function($rule, $action){
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



    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Banners::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }



    public function actionCreate()
    {
        $model = new UploadImage;
        
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post('UploadImage');
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->url = $post['url'];
            $model->main = $post['main'];
            $model->tag = $post['tag'];
            if ($newImage = $model->upload()) {
                $banner = new Banners;
                $banner->image = '/' . $newImage;
                $banner->url = $model->url;
                $banner->main = $model->main;
                $banner->tag = $model->tag;
                if ($banner->save()){
                    Yii::$app->session->setFlash('success', 'Баннер был успешно добавлен.');
                    return $this->redirect(['banner/index']);
                }
            } else {
                Yii::$app->session->setFlash('danger', 'При добавлении баннера произошла ошибка.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    public function actionUpdate($id)
    {
        $banner = $this->findModel($id);
        $model = new UploadImage;
        $model->scenario = UploadImage::SCENARIO_UPDATE;
        $model->url = $banner->url;
        $model->main = $banner->main;
        $model->tag = $banner->tag;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post('UploadImage');
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($newImage = $model->upload()) {
                unlink(Yii::$app->basePath . '/web/' . $banner->image);
                $banner->image = '/' . $newImage;
            }
            $banner->url = $post['url'];
            $banner->main = $post['main'];
            $banner->tag = $post['tag'];
            if ($banner->save()){
                Yii::$app->session->setFlash('success', 'Баннер был успешно изменен.');
                return $this->redirect(['banner/index']);
            } else {
                Yii::$app->session->setFlash('danger', 'При изменении баннера произошла ошибка.');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'image' => $banner->image,
        ]);
    }

    

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (unlink(Yii::$app->basePath . '/web/' . $model->image)){
            $model->delete();
            Yii::$app->session->setFlash('success', 'Баннер был успешно удален.');
        } else {
            Yii::$app->session->setFlash('danger', 'Ошибка удаления баннера.');
        }
        return $this->redirect(['index']);
    }



    protected function findModel($id)
    {
        if (($model = Banners::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
