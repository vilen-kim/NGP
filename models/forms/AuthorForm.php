<?php

namespace app\models\forms;

use yii\base\Model;

class AuthorForm extends Model {

    public $firstname;
    public $lastname;
    public $middlename;
    public $email;
    public $organization;
    public $phone;



    public function rules() {
        $rules = [
            [['firstname', 'lastname', 'email'], 'required', 'message' => 'Это обязательное поле'],
            [['firstname', 'lastname', 'middlename', 'email'], 'string', 'max' => 128],
            ['email', 'email'],
            ['organization', 'string', 'max' => 1024],
            ['phone', 'string', 'max' => 32],
        ];
        return $rules;
    }



    public function attributeLabels() {
        return [
            'email' => '* Электронная почта',
            'firstname' => '* Имя',
            'lastname' => '* Фамилия',
            'middlename' => 'Отчество',
            'organization' => 'Наименование организации (юридического лица)',
            'phone' => 'Номер телефона',
            'fio' => 'ФИО',
        ];
    }



    public function getFio() {
        return $this->lastname . ' ' . $this->firstname . ' ' . $this->middlename;
    }
}
