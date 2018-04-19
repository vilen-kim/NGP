<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Auth;

class RegisterForm extends Model {

    public $username;
    public $password;
    public $passwordRepeat;
    public $role;



    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'Это обязательное поле'],
            ['username', 'string', 'max' => 255],
            ['username', 'unique', 'targetClass' => 'app\models\Auth', 'message' => 'Такое имя уже используется.'],
            [['password', 'passwordRepeat'], 'required', 'message' => 'Это обязательное поле'],
            [['password', 'passwordRepeat'], 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
            ['role', 'string'],
        ];
    }



    public function attributeLabels() {
        return [
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
            'username' => 'Имя пользователя',
            'role' => 'Роль',
        ];
    }



    public function register() {
        if ($this->validate()) {
            $auth = new Auth();
            $auth->username = $this->username;
            $auth->status = Auth::STATUS_INACTIVE;
            $auth->setPassword($this->password);
            $auth->generateAuthKey();
            if ($auth->save()){                
                return $auth;
            } else {
                return false;
            }
        }
    }
    
    
    
    public function create() {
        if ($this->validate()) {
            $auth = new Auth();
            $auth->username = $this->username;
            $auth->status = Auth::STATUS_ACTIVE;
            $auth->setPassword($this->password);
            $auth->generateAuthKey();
            if ($auth->save()){      
                $authManager = Yii::$app->authManager;
                $role = $authManager->getRole($this->role);
                $authManager->assign($role, $auth->id);
                return $auth;
            } else {
                return false;
            }
        }
    }
}