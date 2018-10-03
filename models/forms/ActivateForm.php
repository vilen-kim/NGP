<?php

namespace app\models\forms;

use Yii;
use app\models\Auth;
use yii\base\Model;

class ActivateForm extends Model {

    public $email;



    public function rules() {
        $rules = [
            ['email', 'exist', 
                'targetClass' => '\app\models\Auth',
                'filter' => ['status' => Auth::STATUS_INACTIVE],
                'message' => 'Пользователь с таким электронным адресом не найден или не нуждается в активации.'
            ],
        ];
        $email = require __DIR__ . '/EmailRules.php';
        return array_merge($rules, $email);
    }



    public function attributeLabels() {
        return [
            'email' => 'Электронный адрес',
        ];
    }



    public function sendEmail($html = 'activate') {
        $auth = Auth::findOne(['status' => Auth::STATUS_INACTIVE, 'email' => $this->email]);
        if ($auth) {
            $auth->generatePasswordResetToken();
            if ($auth->save()) {
                $res = Yii::$app->mailer->compose(['html' => $html], ['auth' => $auth])
                    //->setFrom(Yii::$app->params['noreplyEmail'])
                    ->setTo($this->email)
                    ->setSubject("Активация учетной записи на сайте " . Yii::$app->params['siteCaption'])
                    ->send();
                if ($res) {
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        }
    }
}
