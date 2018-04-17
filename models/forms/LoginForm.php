<?php

namespace app\models\forms;

use Yii;
use app\models\Auth;
use yii\base\Model;
use yii\helpers\Html;

class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;



    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'Это обязательное поле'],
            ['username', 'string', 'max' => 255],
            ['rememberMe', 'boolean'],
            ['password', 'required', 'message' => 'Это обязательное поле'],
            ['password', 'string', 'min' => 6],
        ];
    }



    public function attributeLabels() {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить',
        ];
    }



    public function login() {
        $auth = Auth::findByUsername($this->username);

        // Учетная запись не найдена
        if (!$auth) {
            $error = 'Учетная запись не найдена';
            echo $this->addError('username', $error);
            return false;
        }

        // Неактивная запись
        if ($auth->status == Auth::STATUS_INACTIVE) {
            $error = 'Учетная запись не активирована. ';
            echo $this->addError('username', $error);
            return false;
        }

        // Неверный пароль
        if (!$auth->validatePassword($this->password)) {
            $error = 'Неверный пароль.';
            echo $this->addError('password', $error);
            return false;
        }

        // Все ОК
        return Yii::$app->user->login($auth, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }
}
