<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\Auth;

class RegisterForm extends Model {

    public $username;
    public $password;
    public $passwordRepeat;
    public $role_id;
    public $reCaptcha;



    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'Это обязательное поле'],
            ['username', 'string', 'max' => 255],
            ['username', 'unique', 'targetClass' => 'app\models\Auth', 'message' => 'Такое имя уже используется.'],
            [['password', 'passwordRepeat'], 'required', 'message' => 'Это обязательное поле'],
            [['password', 'passwordRepeat'], 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
        ];
    }



    public function attributeLabels() {
        return [
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
            'username' => 'Имя пользователя',
            'role_id' => 'Роль',
        ];
    }



    public function register() {
        if ($this->validate()) {
            $auth = new Auth();
            $auth->username = $this->username;
            $auth->status = Auth::STATUS_INACTIVE;
            $auth->setPassword($this->password);
            $auth->generateAuthKey();
            $auth->role_id = $this->role_id;
            if ($auth->save()){                
                return $auth;
            } else {
                return false;
            }
        }
    }
}