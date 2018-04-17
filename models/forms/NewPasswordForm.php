<?php

namespace app\models\forms;

use yii\base\Model;

/**
 * Это форма для указания нового пароля
 * @property string $password
 * @property string $passwordRepeat
 */
class NewPasswordForm extends Model {

    public $password;
    public $passwordRepeat;

    /**
     * Наименования полей
     * @return type
     */
    public function attributeLabels() {
        return [
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
        ];
    }

    /**
     * Правила валидации
     * @return type
     */
    public function rules() {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
        ];
    }

}
