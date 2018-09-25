<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Auth;
use app\models\UserProfile;
use app\models\RequestExecutive;

class ProfileForm extends Model {

    public $email;
    public $password;
    public $passwordRepeat;
    public $firstname;
    public $lastname;
    public $middlename;
    public $birthdate;
    public $address;
    public $phone;
    public $organization;
    public $role;
    public $position;
    public $kab;
    public $priem;
    public $executive;

    const SCENARIO_UPDATE = 'update';


    public function rules() {
        $rules = [
            [['firstname', 'lastname'], 'required', 'message' => 'Это обязательное поле'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 128],
            [['address', 'organization', 'birthdate', 'phone'], 'safe'],
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
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'birthdate' => 'Дата рождения',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'organization' => 'Организация',
            'position' => 'Должность',
            'kab' => 'Кабинет',
            'priem' => 'Время приема',
        ];
    }



    public function update($auth) {
        if ($this->validate()) {
            if ($this->password) {
                $auth->setPassword($this->password);
                $auth->generateAuthKey();
                if (!$auth->save()) {
                    return $auth->errors;
                }
            }

            $profile = $auth->profile;
            $profile->firstname = $this->firstname;
            $profile->lastname = $this->lastname;
            $profile->middlename = ($this->middlename) ? $this->middlename : '';
            $profile->birthdate = ($this->birthdate) ? Yii::$app->formatter->asTimestamp($this->birthdate) : '';
            $profile->address = ($this->address) ? $this->address : '';
            $profile->phone = ($this->phone) ? $this->phone : '';
            $profile->organization = ($this->organization) ? $this->organization : '';
            if (!$profile->save()) {
                return $profile->errors;
            }

            return true;
        }
    }
}