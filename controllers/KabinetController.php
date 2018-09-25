<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\models\Auth;
use app\models\Request;
use app\models\RequestUser;
use app\models\RequestExecutive;
use app\models\Pages;
use app\models\Menu;
use app\models\Banners;
use app\models\forms\ProfileForm;

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
        $auth = Auth::findOne($user_id);
        $fio = $auth->fio;

        return $this->render('index', [
            'fio' => $fio,
        ]);
    }



    public function actionRequest($type = 0) {
        $user_id = Yii::$app->user->id;
        $isExecutive = (RequestExecutive::findOne(['auth_id' => $user_id])) ? True : False;
        $query = null;
        $switch = null;
        if ($isExecutive == False){
            $type = 0;
        }
        
        switch ($type) {

            case 0:     // Мои обращения
                $switch = 'switchLeft';
                $query = RequestUser::find()
                    ->where(['auth_id' => $user_id])
                    ->joinWith(['request'])
                    ->orderBy(['request_created_at' => SORT_DESC]);
                
                $columns = [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => function ($model, $key, $index, $column){
                            if ($model->request->answer_created_at){
                                return ['style' => 'background: lightgreen;'];
                            } else if ($model->active == RequestUser::STATUS_INACTIVE){
                                return ['style' => 'background: lightgray;'];
                            } else {
                                return [];
                            }
                        }
                    ],
                    [
                        'label' => 'Дата обращения',
                        'attribute' => 'request.request_created_at',
                        'format' => 'date',
                        'headerOptions' => ['style' => 'width: 70px;'],
                    ],
                    [
                        'label' => 'Кому',
                        'attribute' => 'request.requestAuth.fio',
                    ],
                    [
                        'label' => 'Текст обращения',
                        'attribute' => 'request.request_text',
                        'headerOptions' => ['style' => 'width: 50%'],
                    ],
                    [
                        'label' => 'Ответ на обращение',
                        'headerOptions' => ['style' => 'width: 70px'],
                        'content' => function ($model, $key, $index, $column) {
                            if ($model->request->answer_created_at != null) {
                                return Html::a('Посмотреть', '', ['data-id' => $model->request_id, 'class' => 'getAnswer']);
                            }
                        }, 
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{activate} {delete}',
                        'header' => 'Действия',
                        'headerOptions' => ['style' => 'width: 70px'],
                        'buttons' => [
                            'activate' => function ($url, $model, $key) {
                                $icon = '<span class="glyphicon glyphicon-ok"></span>';
                                $url = ['request/activate', 'id' => $model->request_id];
                                return $model->active ? '' : Html::a($icon, $url, ['title' => 'Активировать']);
                            },
                            'delete' => function ($url, $model, $key) {
                                $icon = '<span class="glyphicon glyphicon-trash"></span>';
                                $url = ['request/delete', 'id' => $model->request_id];
                                return $model->active ? '' : Html::a($icon, $url, ['title' => 'Удалить обращение']);
                            },
                        ],

                    ],
                ];
                break;

            case 1:     // Принятые обращения
                $type = -1;
                $switch = 'switchRight';
                $query = Request::find()
                    ->where(['request_auth_id' => $user_id])
                    ->orderBy(['request_created_at' => SORT_DESC]);
                $columns[] = [
                    'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => function ($model, $key, $index, $column){
                            if ($model->answer_created_at){
                                return ['style' => 'background: lightgreen;'];
                            } else {
                                return [];
                            }
                        }
                ];
                $columns[] = [
                    'label' => 'Дата обращения',
                    'attribute' => 'request_created_at',
                    'format' => 'date',
                    'headerOptions' => ['style' => 'width: 70px;'],
                ];
                $columns[] = [
                    'label' => 'От кого',
                    'content' => function ($model, $key, $index, $column) {
                        $authors = null;
                        foreach ($model->requestUsers as $user) {
                            $authors .= $user->auth->fio;
                            if ($user->active == RequestUser::STATUS_INACTIVE) {
                                $authors .= ' (-)';
                            }
                            $authors .= '<br>';
                        };
                        return $authors;
                    }
                ];
                $columns[] = [
                    'label' => 'Текст обращения',
                    'attribute' => 'request_text',
                    'headerOptions' => ['style' => 'width: 50%'],
                ];
                $columns[] = [
                    'label' => 'Ответ на обращение',
                    'headerOptions' => ['style' => 'width: 70px'],
                    'content' => function ($model, $key, $index, $column) {
                        if ($model->answer_created_at != null) {
                            return Html::a('Посмотреть', '', ['data-id' => $model->id, 'class' => 'getAnswer']);
                        }
                    },
                ];
                $columns[] = [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{answer} {reSend} {share} {unShare}',
                    'header' => 'Действия',
                    'headerOptions' => ['style' => 'width: 70px'],
                    'buttons' => [
                        'answer' => function ($url, $model, $key) {
                            $icon = '<span class="glyphicon glyphicon-pencil"></span>';
                            $url = ['request/answer', 'id' => $model->id];
                            return (!$model->answer_created_at) ? Html::a($icon, $url, ['title' => 'Ответить']) : '';
                        },
                        'reSend' => function ($url, $model, $key) {
                            $icon = '<span class="glyphicon glyphicon-share-alt"></span>';
                            $url = '';
                            return !$model->answer_created_at ? Html::a($icon, $url, ['class' => 'reSend', 'data-id' => $model->id, 'title' => 'Перенаправить']) : '';
                        },
                        'share' => function ($url, $model, $key) {
                            $icon = '<span class="glyphicon glyphicon-blackboard"></span>';
                            $url = ['request/share', 'id' => $model->id];
                            return ($model->answer_created_at && !$model->share) ? Html::a($icon, $url, ['title' => 'Расшарить для просмотра']) : '';
                        },
                        'unShare' => function ($url, $model, $key) {
                            $icon = '<span class="glyphicon glyphicon-blackboard" style="color: red"></span>';
                            $url = ['request/un-share', 'id' => $model->id];
                            return ($model->answer_created_at && $model->share) ? Html::a($icon, $url, ['title' => 'Убрать из расшаренных']) : '';
                        },
                    ],

                ];
                break;
        }
        
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        return $this->render('request', [
            'dataProvider' => $dataProvider,
            'isExecutive' => $isExecutive,
            'type' => $type,
            'switch' => $switch,
            'columns' => $columns,
        ]);
    }



    public function actionProfile() {
        $user_id = Yii::$app->user->id;
        $auth = Auth::findOne(['id' => $user_id]);
        $model = new ProfileForm;
        $model->scenario = ProfileForm::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post())){
            $res = $model->update($auth);
            if ($res){
                Yii::$app->session->setFlash('success', "Ваш профиль был успешно изменен.");
                return $this->redirect(['kabinet/index']);
            } else {
                var_dump($res);
            }
        }

        if ($auth) {
            $model->email = $auth->email;
            $model->firstname = $auth->profile->firstname;
            $model->lastname = $auth->profile->lastname;
            $model->middlename = $auth->profile->middlename;
            $model->birthdate = ($auth->profile->birthdate) ? Yii::$app->formatter->asDate($auth->profile->birthdate) : '';
            $model->address = $auth->profile->address;
            $model->phone = $auth->profile->phone;
            $model->organization = $auth->profile->organization;
            if (isset($auth->executive)) {
                $model->executive = true;
                $model->position = $auth->executive->position;
                $model->kab = $auth->executive->kab;
                $model->priem = $auth->executive->priem;
            }

            return $this->render('profile', [
                'model' => $model,
            ]);
        }
    }



    public function actionGetModalRequestAnswer() {
        $id = Yii::$app->request->post('id');
        $model = Request::findOne(['id' => $id]);
        return $this->renderPartial('/modals/answer', [
            'model' => $model,
        ]);
    }



    public function actionGetModalResendRequest() {
        $id = Yii::$app->request->post('id');
        $executiveArray = ArrayHelper::map(RequestExecutive::find()->where(['<>' , 'auth_id', Yii::$app->user->id])->all(), 'auth_id', 'fioPosition');
        return $this->renderPartial('/modals/resend', [
            'id' => $id,
            'executiveArray' => $executiveArray,
        ]);
    }
}
