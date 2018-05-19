<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Auth;
use app\models\UserProfile;
use app\models\RequestExecutive;
use himiklab\yii2\recaptcha\ReCaptchaValidator;

class RegisterForm extends Model {

    public $email;
    public $password;
    public $passwordRepeat;
    public $firstname;
    public $lastname;
    public $middlename;
    public $role;
    public $position;
    public $kab;
    public $priem;
    public $executive;
    public $reCaptcha;

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_UPDATE = 'update';



    public function rules() {
        $rules = [
            [['firstname', 'lastname'], 'required', 'message' => 'Это обязательное поле'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 128],
            ['email', 'unique', 'targetClass' => 'app\models\Auth',
                'message' => 'Такая электронная почта уже используется.',
                'except' => self::SCENARIO_UPDATE],
            ['role', 'string', 'except' => self::SCENARIO_REGISTER],
            ['executive', 'integer', 'except' => self::SCENARIO_REGISTER],
            ['position', 'string', 'max' => 512, 'except' => self::SCENARIO_REGISTER],
            ['kab', 'string', 'max' => 32, 'except' => self::SCENARIO_REGISTER],
            ['priem', 'string', 'max' => 256, 'except' => self::SCENARIO_REGISTER],
            [['reCaptcha'], ReCaptchaValidator::className(), 'secret' => Yii::$app->reCaptcha->secret,
                'uncheckedMessage' => 'Подтвердите, что Вы не бот.',
                'except' => self::SCENARIO_UPDATE],
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
            'executive' => 'Должностное лицо',
            'position' => 'Должность',
            'kab' => 'Кабинет',
            'priem' => 'Время приема',
        ];
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
                $profile->middlename = ($this->middlename) ? $this->middlename : '';
                if (!$profile->save()) {
                    Yii::$app->session->setFlash('danger', 'Ошибка сохранения профиля. Повторите попытку регистрации позже.');
                    throw new Exception("Ошибка сохранения профиля");
                }
                
                if ($this->executive){
                    $executive = new RequestExecutive();
                    $executive->auth_id = $auth->id;
                    $executive->position = ($this->position) ? $this->position : '';
                    $executive->kab = ($this->kab) ? $this->kab : '';
                    $executive->priem = ($this->priem) ? $this->priem : '';
                    if (!$executive->save()) {
                        Yii::$app->session->setFlash('danger', 'Ошибка сохранения данных должностного лица. Повторите попытку регистрации позже.');
                        throw new Exception("Ошибка сохранения должностного лица");
                    }
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
                        return $auth;
                    } else {
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
            if ($this->password) {
                $auth->setPassword($this->password);
                $auth->generateAuthKey();
                if (!$auth->save()) {
                    return false;
                }
            }

            $profile = $auth->profile;
            $profile->firstname = $this->firstname;
            $profile->lastname = $this->lastname;
            $profile->middlename = ($this->middlename) ? $this->middlename : '';
            if (!$profile->save()) {
                return false;
            }

            if ($this->executive){
                $executive = null;
                if (!isset($auth->executive)){
                    $model = new RequestExecutive;
                    $model->auth_id = $auth->id;
                    if (!$model->save()){
                        return false;
                    }
                    $executive = $model;
                } else {
                    $executive = $auth->executive;
                }
                $executive->position = ($this->position) ? $this->position : '';
                $executive->kab = ($this->kab) ? $this->kab : '';
                $executive->priem = ($this->priem) ? $this->priem : '';
                if (!$executive->save()) {
                    return false;
                }
            } else if (isset($auth->executive)){
                $auth->executive->delete();
            }

            $authManager = Yii::$app->authManager;
            $role = $authManager->getRole($this->role);
            $authManager->revokeAll($auth->id);
            $authManager->assign($role, $auth->id);
            return $auth;
        }
    }
}
