<?php

namespace app\models\forms;

use yii\base\Model;

class NewPasswordForm extends Model {

    public $password;
    public $passwordRepeat;

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';



    public function attributeLabels() {
        return [
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
        ];
    }



    public function rules() {
        $password = require __DIR__ . '/PasswordRules.php';
        return $password;
    }
}
