<?php

namespace app\models\forms;

use Yii;
use app\models\Auth;
use yii\base\Model;

class ActivateForm extends Model {

	public $email;



	public function rules() {
		return [
			['email', 'filter', 'filter' => 'trim'],
			['email', 'required'],
			['email', 'string', 'max' => 255],
			['email', 'email'],
			['email', 'exist',
				'targetClass' => '\app\models\Auth',
				'filter' => ['status' => Auth::STATUS_INACTIVE],
				'message' => 'Пользователь с таким электронным адресом не найден или не нуждается в активации.'
			],
		];
	}



	public function attributeLabels() {
		return [
			'email' => 'Электронный адрес',
		];
	}



	public function sendEmail() {
		if ($auth = Auth::findOne(['status' => Auth::STATUS_INACTIVE, 'email' => $this->email])) {
			$auth->generatePasswordResetToken();
			if ($auth->save()) {
				$res = Yii::$app->mailer->compose(['html' => $auth->role], ['auth' => $auth])
				->setFrom(Yii::$app->params['supportEmail'])
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
