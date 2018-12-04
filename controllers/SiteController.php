<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Auth;
use app\models\Pages;
use app\models\Banners;
use app\models\CallDoctor;
use app\models\Request;
use app\models\RequestExecutive;
use app\models\forms\AuthorForm;
use app\models\forms\RequestForm;
use app\components\News;
use app\components\MenuItems;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use DateTime;
use DateInterval;

class SiteController extends \yii\web\Controller {



    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }



    public function actionIndex() {
        $model = new CallDoctor;
        if (!Yii::$app->user->isGuest){
            $auth = Auth::findOne(Yii::$app->user->id);
            $model->auth_id = $auth->id;
            $model->fio = $auth->fio;
            $model->phone = $auth->profile->phone;
            $model->address = $auth->profile->address;
            $model->email = $auth->email;
        }
        $lastID = Pages::find()->select('id')->where(['in', 'category_id', [2, 3, 4]])->orderBy(['id' => SORT_DESC])->limit(5)->all();
        $items = null;
        foreach ($lastID as $id) {
            $news[] = new News($id->id, 600);
        }
        $banners = Banners::findAll(['main' => true]);
        return $this->render('index', [
            'news' => $news,
            'banners' => $banners,
            'model' => $model,
        ]);
    }



    public function actionPhone() {
        return $this->render('phone');
    }



    public function actionMobilePhone() {
        return $this->render('mobilePhone');
    }



    public function actionShow($id) {
        return $this->render('show', [
            'model' => $this->findModel($id),
        ]);
    }



    public function actionMenu() {
        $menu = new MenuItems();
        return $this->render('menu', [
            'menu' => $menu,
        ]);
    }



    public function actionNews() {
        $news = Pages::find()->select(['id', 'caption'])->where(['in', 'category_id', [2, 3, 4]])->orderBy(['id' => SORT_DESC])->asArray()->all();
        return $this->render('news', [
            'news' => $news,
        ]);
    }



    public function actionBanners() {
        $banners = Banners::find()->all();
        return $this->render('banners', ['banners' => $banners]);
    }



    public function actionEyeOn() {
        $css = [
            'body' => [
                'transition' => '1s',
                'background' => 'black',
                'color' => 'white',
                'fontSize' => '16px',
            ],
            'ul.breadcrumb' => [
                'transition' => '1s',
                'background' => 'black',
                'color' => 'white',
            ],
            'div.callDoctor' => [
                'transition' => '1s',
                'background' => 'black',
                'color' => 'white',
            ],
            '#modalDoctor .modal-header; #modalDoctor .modal-body' => [
                'transition' => '1s',
                'background' => 'black',
                'color' => 'white',
            ],
            '#bottomHolder a' => [
                'transition' => '1s',
                'background' => 'none',
                'color' => 'cyan',
            ],
            '#eyePanel' => [
                'transition' => '1s',
                'top' => '70px',
            ]
        ];
        $session = Yii::$app->session;
        $session->open();
        $session->set('eye', True);
        $session->set('css', $css);
        $session->set('cssText', $this->cssTransform($css));
        return true;
    }



    public function actionEyeChange() {
        $post = Yii::$app->request->post();
        $css = Yii::$app->session->get('css');

        if (isset($post['background'])){
            $css['body']['background'] = $post['background'];
            $css['ul.breadcrumb']['background'] = $post['background'];
            $css['div.callDoctor']['background'] = $post['background'];
            $css['#modalDoctor .modal-header; #modalDoctor .modal-body']['background'] = $post['background'];
        }
        if (isset($post['color'])){
            $css['body']['color'] = $post['color'];
            $css['ul.breadcrumb']['color'] = $post['color'];
            $css['div.callDoctor']['color'] = $post['color'];
            $css['#modalDoctor .modal-header; #modalDoctor .modal-body']['color'] = $post['color'];
        }
        if (isset($post['link'])){
            $css['#bottomHolder a']['color'] = $post['link'];
        }
        if (isset($post['fontSize'])){
            $css['body']['font-size'] = $post['fontSize'];
        }
        
        $session = Yii::$app->session;
        $session->open();
        $session->set('css', $css);
        $session->set('cssText', $this->cssTransform($css));
    }



    public function actionEyeOff() {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('eye');
        $session->remove('css');
        $session->remove('cssText');
        return true;
    }



    private function cssTransform($css) {
        $result = null;
        foreach($css as $key => $value){
            if (is_array($value)){
                $result .= "$key { " . $this->cssTransform($value) . " } ";
            } else {
                $result .= "$key: $value;";
            }
        }
        return $result;
    }



    public function actionCallDoctor() {
        $model = new CallDoctor;
        if (!Yii::$app->user->isGuest){
            $model->auth_id = Yii::$app->user->id;
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save() && $model->sendEmail()){
                Yii::$app->session->setFlash('success', 'Ваша заявка была отправлена на рассмотрение.');
            } else {
                Yii::$app->session->setFlash('danger', 'При отправке заявки возникла ошибка. Пожалуйста, повторите позже.');
            }
            return $this->redirect(['site/index']);
        }

        if (!Yii::$app->user->isGuest){
            $auth = Auth::findOne(Yii::$app->user->id);
            $model->auth_id = $auth->id;
            $model->fio = $auth->fio;
            $model->phone = $auth->profile->phone;
            $model->address = $auth->profile->address;
            $model->email = $auth->email;
        }

        return $this->render('callDoctor', [
            'model' => $model,
        ]);
        
    }



    public function actionShare($id = false, $date = false) {
        $array = [];
        $query = Request::find()->where(['share' => true])->orderBy(['request_created_at' => SORT_DESC]);
        if ($date){
            $date = DateTime::createFromFormat('d.m.Y', $date);
            $date->setTime(0, 0, 0);
            $unixDateStart = $date->getTimeStamp();
            $date->add(new DateInterval('P1D'));
            $date->sub(new DateInterval('PT1S'));
            $unixDateEnd = $date->getTimeStamp();
            $query->andWhere(['between', 'request_created_at', $unixDateStart, $unixDateEnd]);
        }
        $countQuery = clone $query;
        $totalCount = $countQuery->count();
        $pages = new Pagination(['totalCount' => $totalCount, 'pageSize' => 10]);
        $pages->pageSizeParam = false;
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();
        $cnt = 1;
        foreach ($model as $element) {
            $i = Html::tag('i', $cnt++ . '. Вопрос от ' . Yii::$app->formatter->asDate($element->request_created_at));
            $pHeader = Html::tag('p', $i, ['class' => 'small', 'style' => 'font-weight: bold']);
            $pContent = Html::tag('p', Html::encode($element->request_text), ['class' => 'text-justify']);
            $div11 = Html::tag('div', $pHeader . $pContent, ['class' => 'col-md-11']);
            $pdfLink = Html::a(Html::img('/images/pdf.svg', ['width' => '40px']), "/pdf/$element->id.pdf", ['class' => 'getPdf']);
            $div1 = Html::tag('div', $pdfLink, ['class' => 'col-md-1 text-center']);
            $divRow = Html::tag('div', $div11 . $div1, ['class' => 'row']);
            $question = $divRow;

            $i = Html::tag('i', 'Ответ от ' . Yii::$app->formatter->asDate($element->answer_created_at));
            $pHeader = Html::tag('p', "$i", ['class' => 'small', 'style' => 'font-weight: bold']);
            $pContent = Html::tag('p', Html::encode($element->answer_text), ['class' => 'text-justify']);
            $answer = $pHeader . $pContent;

            $array[] = [
                'header' => $question,
                'content' => $answer,
            ];
        }
        return $this->render('share', [
            'model' => $model,
            'array' => $array,
            'pages' => $pages,
        ]);
    }



    public function actionRequest() {
        $author = new AuthorForm;
        $letter = new RequestForm;

        $radioArray = [
            'organization' => 'БУ ХМАО-Югры "Няганская городская поликлиника"',
            'fio' => 'Фамилия, имя, отчество должностного лица',
            'position' => 'Должность должностного лица',
        ];
        Yii::$app->session->remove('authors');
        if (Yii::$app->user->can('user')) {
            $auth = Auth::findIdentity(Yii::$app->user->id);
            $author->email = $auth->email;
            $author->lastname = $auth->profile->lastname;
            $author->firstname = $auth->profile->firstname;
            $author->middlename = $auth->profile->middlename;
            $author->organization = $auth->profile->organization;
            $author->phone = $auth->profile->phone;
        }
        $executiveArray = ArrayHelper::map(RequestExecutive::find()
        ->joinWith(['auth.profile'])
        ->orderBy('lastname')
        ->all(), 'auth.id', 'fioPosition');
        return $this->render('request', [
            'executiveArray' => $executiveArray,
            'model' => $author,
            'letter' => $letter,
            'radioArray' => $radioArray,
        ]);
    }



    protected function findModel($id) {
        if (($model = Pages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена.');
    }

}
