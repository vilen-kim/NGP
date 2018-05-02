<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Auth;
use app\models\UserProfile;
use himiklab\yii2\recaptcha\ReCaptchaValidator;

class RegisterForm extends Model {

    public $email;
    public $password;
    public $passwordRepeat;
    public $firstname;
    public $lastname;
    public $middlename;
    public $role;
    public $reCaptcha;

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';



    public function rules() {
        $rules = [
            [['firstname', 'lastname'], 'required', 'message' => 'Это обязательное поле'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 128],
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
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
        ];
    }



    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_REGISTER] = ['email', 'password', 'passwordRepeat', 'reCaptcha', 'firstname', 'lastname', 'middlename'];
        $scenarios[static::SCENARIO_CREATE] = ['email', 'password', 'passwordRepeat', 'role', 'reCaptcha', 'firstname', 'lastname', 'middlename'];
        $scenarios[static::SCENARIO_UPDATE] = ['password', 'passwordRepeat', 'role', 'reCaptcha', 'firstname', 'lastname', 'middlename'];
        return $scenarios;
    }



    public function register() {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $auth = new Auth();
                $auth->email = $this->email;
                $auth->status = (Yii::$app->user->can('admin')) ? Auth::STATUS_ACTIVE : Auth::STATUS_INACTIVE;
                $auth->setPassword($this->password);
                $auth->generateAuthKey();
                if (!$auth->save()) {
                    Yii::$app->session->setFlash('danger', 'Ошибка сохранения учетной записи. Повторите попытку регистрации позже.');
                    throw new Exception("Ошибка сохранения учетной записи");
                }

                $profile = new UserProfile();
                $profile->auth_id = $auth->id;
                $profile->firstname = $this->firstname;
                $profile->lastname = $this->lastname;
                $profile->middlename = $this->middlename;
                if (!$profile->save()) {
                    Yii::$app->session->setFlash('danger', 'Ошибка сохранения профиля. Повторите попытку регистрации позже.');
                    throw new Exception("Ошибка сохранения профиля");
                }

                $this->role = ($this->role) ? $this->role : 'user';
                $role = Yii::$app->authManager->getRole($this->role);
                Yii::$app->authManager->assign($role, $auth->id);
                $transaction->commit();

                if (Yii::$app->user->can('admin')) {
                    Yii::$app->session->setFlash('success', 'Учетная запись была успешно зарегистрирована и активирована.');
                    return $auth;
                } else {
                    $activate = new ActivateForm();
                    $activate->email = $auth->email;
                    if ($activate->sendEmail()) {
                        Yii::$app->session->setFlash('success', 'Ваша учетная запись была успешно зарегистрирована.<br>Для ее активации пройдите по ссылке, отправленной Вам на электронную почту.');
                        return $auth;
                    } else {
                        Yii::$app->session->setFlash('warning', 'Ваша учетная запись была успешно зарегистрирована, но при отправке электронного письма произошла ошибка. Активировать учетную запись Вы можете самостоятельно при попытке входа.');
                        return $auth;
                    }
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }



    public function update($auth) {
        if ($this->validate()) {
            if ($this->password != '1234567890') {
                $auth->setPassword($this->password);
                $auth->generateAuthKey();
                if (!$auth->save()) {
                    return false;
                }
            }

            $profile = $auth->profile;
            $profile->firstname = $this->firstname;
            $profile->lastname = $this->lastname;
            $profile->middlename = $this->middlename;
            if (!$profile->save()) {
                return false;
            }

            $authManager = Yii::$app->authManager;
            $role = $authManager->getRole($this->role);
            $authManager->revokeAll($auth->id);
            $authManager->assign($role, $auth->id);
            return $auth;
        }
    }
}
