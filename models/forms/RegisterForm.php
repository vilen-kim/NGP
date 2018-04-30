<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Auth;
use himiklab\yii2\recaptcha\ReCaptchaValidator;

class RegisterForm extends Model {

    public $email;
    public $password;
    public $passwordRepeat;
    public $role;
    public $reCaptcha;

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';



    public function rules() {
        $rules = [
            ['email', 'unique', 'targetClass' => 'app\models\Auth', 'message' => 'Такая электронная почта уже используется.'],
            ['role', 'string'],
            [['reCaptcha'], ReCaptchaValidator::className(), 'secret' => Yii::$app->reCaptcha->secret, 'uncheckedMessage' => 'Подтвердите, что Вы не бот.'],
        ];
        $email = require __DIR__ . '/EmailRules.php';
        $password = require __DIR__ . '/PasswordRules.php';
        return array_merge($rules, $password, $email);
    }



    public function attributeLabels() {
        return [
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
            'role' => 'Роль',
        ];
    }



    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_REGISTER] = ['email', 'password', 'passwordRepeat', 'reCaptcha'];
        $scenarios[static::SCENARIO_CREATE] = ['email', 'password', 'passwordRepeat', 'role', 'reCaptcha'];
        $scenarios[static::SCENARIO_UPDATE] = ['password', 'passwordRepeat', 'role', 'reCaptcha'];
        return $scenarios;
    }



    public function register() {
        if ($this->validate()) {
            $auth = new Auth();
            $auth->email = $this->email;
            $auth->status = Auth::STATUS_INACTIVE;
            $auth->setPassword($this->password);
            $auth->generateAuthKey();
            if ($auth->save()) {
                $role = Yii::$app->authManager->getRole('user');
                Yii::$app->authManager->assign($role, $auth->id);
                $activate = new ActivateForm();
                $activate->email = $auth->email;
                if ($activate->sendEmail()) {
                    Yii::$app->session->setFlash('success', 'Ваша учетная запись была успешно зарегистрирована.<br>Для ее активации пройдите по ссылке, отправленной Вам на электронную почту.');
                    return $auth;
                } else {
                    Yii::$app->session->setFlash('warning', 'Ваша учетная запись была успешно зарегистрирована, но при отправке электронного письма произошла ошибка. Активировать учетную запись Вы можете самостоятельно при попытке входа.');
                    return $auth;
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Произошла ошибка. Повторите попытку регистрации позже.');
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
            if ($auth->save()) {
                $authManager = Yii::$app->authManager;
                $role = $authManager->getRole($this->role);
                $authManager->assign($role, $auth->id);
                return $auth;
            } else {
                return false;
            }
        }
    }



    public function update($auth) {
        if ($this->validate()) {
            if ($this->password) {
                $auth->setPassword($this->password);
                $auth->generateAuthKey();
                if (!$auth->save()) {
                    return false;
                }
            }
            $authManager = Yii::$app->authManager;
            $role = $authManager->getRole($this->role);
            $authManager->revokeAll($auth->id);
            $authManager->assign($role, $auth->id);
            return $auth;
        }
    }
}
