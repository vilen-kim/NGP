<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\RequestWhom;

class WhomForm extends Model {

    public $firstname;
    public $lastname;
    public $middlename;
    public $email;
    public $position;
    public $organization;
    public $phone;
    public $kab;
    public $priem;



    public function rules() {
        $rules = [
            [['firstname', 'lastname'], 'required', 'message' => 'Это обязательное поле'],
            [['firstname', 'lastname', 'middlename', 'priem'], 'string', 'max' => 255],
            [['email', 'position'], 'required', 'message' => 'Это обязательное поле'],
            ['email', 'email'],
            ['kab', 'string', 'max' => 32],
            [['email', 'phone'], 'string', 'max' => 128],
            [['position', 'organization'], 'string', 'max' => 512],
        ];
        return $rules;
    }



    public function attributeLabels() {
        return [
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'email' => 'Электронная почта',
            'position' => 'Должность',
            'organization' => 'Организация',
            'phone' => 'Телефон',
            'kab' => 'Кабинет',
            'priem' => 'Прием',
        ];
    }



    public function create() {
        if ($this->validate()) {
            $whom = new RequestWhom();
            $whom->firstname = $this->firstname;
            $whom->lastname = $this->lastname;
            $whom->middlename = $this->middlename;
            $whom->email = $this->email;
            $whom->position = $this->position;
            $whom->organization = $this->organization;
            $whom->phone = $this->phone;
            $whom->kab = $this->kab;
            $whom->priem = $this->priem;
            if (Yii::$app->user->can('admin') && $whom->save()) {
                return $whom;
            } else {
                return false;
            }
        }
    }
    
    public function update($whom) {
        if ($this->validate()) {
            $whom->firstname = $this->firstname;
            $whom->lastname = $this->lastname;
            $whom->middlename = $this->middlename;
            $whom->email = $this->email;
            $whom->position = $this->position;
            $whom->organization = $this->organization;
            $whom->phone = $this->phone;
            $whom->kab = $this->kab;
            $whom->priem = $this->priem;
            if (Yii::$app->user->can('admin') && $whom->save()) {
                return $whom;
            } else {
                return false;
            }
        }
    }
}
