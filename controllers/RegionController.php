<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\RegionStreet;
use app\models\RegionDoctor;
use app\models\RegionAddress;
use app\models\RegionLink;


class RegionController extends \yii\web\Controller
{
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
                    return $this->redirect(['site/index']);
                }
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




    public function actionAddressAdd()
    {
        $model = new RegionAddress();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Адрес был успешно добавлен.');
            return $this->redirect(['region/address-index']);
        }

        return $this->render('address/add', [
            'model' => $model,
        ]);
    }


    public function actionAddressDelete()
    {
        if ($this->findAddress($id)->delete()){
            Yii::$app->session->setFlash('success', 'Адрес был успешно удален.');
        } else {
            Yii::$app->session->setFlash('success', 'При удалении адреса возникла ошибка.');
        }
        return $this->redirect(['region/address-index']);
    }


    public function actionAddressIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RegionAddress::find(),
        ]);

        return $this->render('address/index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionAddressUpdate()
    {
        $model = $this->findAddress($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Адрес был успешно изменен.');
            return $this->redirect(['region/address-index']);
        }

        return $this->render('address/update', [
            'model' => $model,
        ]);
    }




    public function actionDoctorAdd()
    {
        $model = new RegionDoctor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись врача была успешно добавлена.');
            return $this->redirect(['region/doctor-index']);
        }

        return $this->render('doctor/add', [
            'model' => $model,
        ]);
    }


    public function actionDoctorDelete()
    {
        if ($this->findDoctor($id)->delete()){
            Yii::$app->session->setFlash('success', 'Запись врача была успешно удалена.');
        } else {
            Yii::$app->session->setFlash('success', 'При удалении записи врача возникла ошибка.');
        }
        return $this->redirect(['region/doctor-index']);
    }


    public function actionDoctorIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RegionDoctor::find(),
        ]);

        return $this->render('doctor/index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionDoctorUpdate()
    {
        $model = $this->findDoctor($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись врача была успешно изменена.');
            return $this->redirect(['region/doctor-index']);
        }

        return $this->render('doctor/update', [
            'model' => $model,
        ]);
    }




    public function actionLinkAdd()
    {
        $model = new RegionLink();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Связь врача и адреса была успешно добавлена.');
            return $this->redirect(['region/link-index']);
        }

        return $this->render('link/add', [
            'model' => $model,
        ]);
    }


    public function actionLinkDelete()
    {
        if ($this->findLink($id)->delete()){
            Yii::$app->session->setFlash('success', 'Связь врача и адреса была успешно удалена.');
        } else {
            Yii::$app->session->setFlash('success', 'При удалении связи возникла ошибка.');
        }
        return $this->redirect(['region/link-index']);
    }


    public function actionLinkIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RegionLink::find(),
        ]);

        return $this->render('link/index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionLinkUpdate()
    {
        $model = $this->findLink($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Связь врача и адреса была успешно изменена.');
            return $this->redirect(['region/link-index']);
        }

        return $this->render('link/update', [
            'model' => $model,
        ]);
    }




    public function actionStreetAdd()
    {
        $model = new RegionStreet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Улица была успешно добавлена.');
            return $this->redirect(['region/street-index']);
        }

        return $this->render('street/add', [
            'model' => $model,
        ]);
    }


    public function actionStreetDelete($id)
    {
        if ($this->findStreet($id)->delete()){
            Yii::$app->session->setFlash('success', 'Улица был успешно удалена.');
        } else {
            Yii::$app->session->setFlash('success', 'При удалении улицы возникла ошибка.');
        }
        return $this->redirect(['region/street-index']);
    }


    public function actionStreetIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RegionStreet::find(),
        ]);

        return $this->render('street/index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionStreetUpdate($id)
    {
        $model = $this->findStreet($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Улица была успешно изменена.');
            return $this->redirect(['region/street-index']);
        }

        return $this->render('street/update', [
            'model' => $model,
        ]);
    }




    protected function findAddress($id)
    {
        if (($model = RegionAddress::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findDoctor($id)
    {
        if (($model = RegionDoctor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findStreet($id)
    {
        if (($model = RegionStreet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    protected function findLink($id)
    {
        if (($model = RegionLink::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
