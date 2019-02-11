<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\CallDoctor;



class CallDoctorController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['registrator'],
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



    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => CallDoctor::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);   
    }



    public function actionWorking($id){
        $model = $this->findModel($id);
        if ($model){
            $model->scenario = CallDoctor::SCENARIO_CLOSE;
            $model->touch('dateWorking');
            $model->doctor_id = Yii::$app->user->id;
            $model->closed = true;
            if ($model->save()){
                Yii::$app->session->setFlash('success', "Заявка была успешно закрыта.");
            } else {
                Yii::$app->session->setFlash('danger', "В процессе закрытия заявки произошла ошибка.");
            }
        }
        return $this->redirect(['index']);
    }



    public function actionGetModalInfo() {
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        return $this->renderPartial('/modals/callInfo', [
            'model' => $model,
        ]);
    }



    public function actionGetModalComment() {
        $callDoctor = Yii::$app->request->post('CallDoctor');
        if ($callDoctor){
            $model = $this->findModel($callDoctor['id']);
            $model->comment .= '<br>' . $callDoctor['comment'];
            $model->scenario = CallDoctor::SCENARIO_CLOSE;
            if ($model->save()){
                Yii::$app->session->setFlash('success', "Комментарий был успешно добавлен.");
            } else {
                Yii::$app->session->setFlash('danger', "В процессе добавления комментария произошла ошибка.");
            }
            return $this->redirect('index');
        }

        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->comment = '';
        return $this->renderPartial('/modals/callComment', [
            'model' => $model,
        ]);
    }



    protected function findModel($id)
    {
        if (($model = CallDoctor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
