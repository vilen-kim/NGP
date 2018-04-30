<?php

namespace app\models\forms;

use Yii;
use yii\helpers\Html;
use app\models\Auth;
use yii\base\Model;

class LoginForm extends Model {

    public $email;
    public $password;
    public $rememberMe = true;



    public function rules() {
        $rules = [
            ['rememberMe', 'boolean'],
            ['password', 'required', 'message' => 'Это обязательное поле'],
            ['password', 'string', 'min' => 6],
        ];
        $email = require __DIR__ . '/EmailRules.php';
        return array_merge($rules, $email);
    }



    public function attributeLabels() {
        return [
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить',
        ];
    }



    public function login() {
        $auth = Auth::findByEmail($this->email);

        // Учетная запись не найдена
        if (!$auth) {
            $error = 'Такой адрес электронной почты не найден';
            echo $this->addError('email', $error);
            return false;
        }

        // Неактивная запись
        if ($auth->status == Auth::STATUS_INACTIVE) {
            $error = 'Учетная запись не активирована. ';
            $error .= Html::a("Выслать письмо для повторной активации.", ['auth/activate', 'email' => $auth->email]);
            echo $this->addError('email', $error);
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
