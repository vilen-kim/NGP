<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Request;
use app\models\RequestUser;
use app\models\RequestExecutive;

class KabinetController extends \yii\web\Controller {



    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user'],
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
        $user_id = Yii::$app->user->id;
        $isExecutive = RequestExecutive::findOne(['auth_id' => $user_id]);
        if (!$isExecutive){
            $type = 'fromMe';
        } else {
            $type = Yii::$app->session->get('requestType');
            $type = (!$type) ? 'fromMe' : $type;
        }
        $detailView = null;
        $countFromMe['inactive'] = RequestUser::find()
            ->where(['auth_id' => $user_id])
            ->andWhere(['active' => RequestUser::STATUS_INACTIVE])
            ->count();
        $countFromMe['no_answer'] = RequestUser::find()
            ->joinWith(['request'])
            ->where(['auth_id' => $user_id])
            ->andWhere(['active' => RequestUser::STATUS_ACTIVE])
            ->andwhere(['is', 'request.answer_text', null])
            ->count();
        $countFromMe['answer'] = RequestUser::find()
            ->joinWith(['request'])
            ->where(['auth_id' => $user_id])
            ->andWhere(['active' => RequestUser::STATUS_ACTIVE])
            ->andwhere(['is not', 'request.answer_text', null])
            ->count();
        $countToMe['no_answer'] = Request::find()
            ->where(['request_auth_id' => $user_id])
            ->andWhere(['is', 'answer_text', null])
            ->count();
        $countToMe['answer'] = Request::find()
            ->where(['request_auth_id' => $user_id])
            ->andWhere(['is not', 'answer_text', null])
            ->count();
        if ($type == 'toMe'){
            $detailView = $this->actionGetRequestsToMe();
        } else {
            $detailView = $this->actionGetRequestsFromMe();
        }
        
        return $this->render('index', [
            'countFromMe' => $countFromMe,
            'countToMe' => $countToMe,
            'user_id' => $user_id,
            'detailView' => $detailView,
            'isExecutive' => $isExecutive,
            'type' => $type,
        ]);
    }



    public function actionGetRequestsFromMe() {
        Yii::$app->session->set('requestType', 'fromMe');
        $num = 1;
        $model = RequestUser::find()
        ->where(['auth_id' => Yii::$app->user->id])
        ->joinWith(['request'])
        ->orderBy(['active' => SORT_DESC, 'request_created_at' => SORT_DESC])
        ->all();
        if (!$model){
            return false;
        }
        $result = null;
        foreach ($model as $req) {
            $color = 'none';
            $status = null;
            $actions = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['request/view', 'id' => $req->request_id], ['title' => 'Посмотреть']);
            if ($req->active == RequestUser::STATUS_INACTIVE) {
                $status = 'Ожидает активации...';
                $color = 'orange';
                $actions .= Html::a('<span class="glyphicon glyphicon-ok"></span>', ['request/active', 'id' => $req->request_id], ['title' => 'Активировать', 'class' => 'text-success', 'style' => 'margin-left: 10px;']);
                $actions .= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['request/delete', 'id' => $req->request_id], ['title' => 'Удалить', 'style' => 'margin-left: 10px;', 'class' => 'text-danger']);
            } else if (!$req->request->answer_text) {
                $status = 'Ожидает ответа...';
                $color = 'lightblue';
            } else if ($req->request->answer_text) {
                $status = 'Завершено.';
                $color = 'lightgreen';
            }
            $result .= DetailView::widget([
                'model' => $req,
                'attributes' => [
                    [
                        'label' => '№ п/п',
                        'value' => $num++,
                        'captionOptions' => ['style' => ['background' => $color]],
                    ],
                    [
                        'label' => 'Дата обращения',
                        'value' => $req->request->request_created_at,
                        'format' => 'date',
                    ],
                    [
                        'label' => 'Кому',
                        'value' => $req->request->requestAuth->executive->position . ' ' . $req->request->requestAuth->fio,
                    ],
                    [
                        'label' => 'Текст',
                        'value' => mb_substr($req->request->request_text, 0, 300) . '...',
                    ],
                    [
                        'label' => 'Статус обращения',
                        'value' => $status,
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Действие',
                        'value' => $actions,
                        'format' => 'raw',
                    ],
                ],
            ]);
        }
        return $result;
    }



    public function actionGetRequestsToMe() {
        Yii::$app->session->set('requestType', 'toMe');
        $num = 1;
        $model = Request::find()
        ->where(['request_auth_id' => Yii::$app->user->id])
        ->joinWith(['requestUsers'])
        ->orderBy(['answer_created_at' => SORT_DESC, 'request_created_at' => SORT_DESC])
        ->all();
        if (!$model){
            return false;
        }
        $result = null;
        foreach ($model as $req) {
            $color = 'none';
            $status = null;
            $authors = null;
            foreach ($req->requestUsers as $user) {
                $authors .= $user->auth->fio;
                if ($user->active == RequestUser::STATUS_INACTIVE) {
                    $authors .= ' (-)';
                }
                $authors .= '<br>';
            }
            $actions = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['request/view', 'id' => $req->id], ['title' => 'Посмотреть']);
            if (!$req->answer_text) {
                $status = 'Ожидает ответа...';
                $color = 'lightblue';
                $actions .= Html::a('<span class="glyphicon glyphicon-share-alt"></span>', ['request/answer', 'id' => $req->id], ['title' => 'Ответить', 'style' => 'margin-left: 10px;']);
            } else if ($req->answer_text) {
                $status = 'Завершено.';
                $color = 'lightgreen';
            }
            $result .= DetailView::widget([
                'model' => $req,
                'attributes' => [
                    [
                        'label' => '№ п/п',
                        'value' => $num++,
                        'captionOptions' => ['style' => ['background' => $color]],
                    ],
                    [
                        'label' => 'Дата обращения',
                        'value' => $req->request_created_at,
                        'format' => 'date',
                    ],
                    [
                        'label' => 'Авторы',
                        'value' => $authors,
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Текст',
                        'value' => mb_substr($req->request_text, 0, 300) . '...',
                    ],
                    [
                        'label' => 'Статус обращения',
                        'value' => $status,
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Действие',
                        'value' => $actions,
                        'format' => 'raw',
                    ],
                ],
            ]);
        }
        return $result;
    }
}
