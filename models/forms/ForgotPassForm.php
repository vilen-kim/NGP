<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Auth;

/**
 * Это форма для сброса пароля
 * Запрашивается только email
 * @property string $email
 */
class ForgotPassForm extends Model {

    public $email;

    /**
     * Правила валидации
     * @return type
     */
    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\Auth',
                'filter' => ['status' => Auth::STATUS_ACTIVE],
                'message' => 'Нет учетной записи с таким электронным адресом или она не активирована.'
            ],
        ];
    }

    /**
     * Наименования полей
     * @return type
     */
    public function attributeLabels() {
        return [
            'email' => 'Электронный адрес',
        ];
    }

    public function sendEmail() {
        $model = Auth::findOne(['status' => Auth::STATUS_ACTIVE, 'email' => $this->email]);

        if ($model) {
            $model->generatePasswordResetToken();
            if ($model->save()) {
                return \Yii::$app->mailer->compose(['html' => 'password'], ['auth' => $model])
                        ->setFrom(Yii::$app->params['supportEmail'])
                        ->setTo($this->email)
                        ->setSubject("Сброса пароля на сайте " . Yii::$app->params['siteCaption'])
                        ->send();
            }
        }
        return false;
    }

}
