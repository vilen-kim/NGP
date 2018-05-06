<?php

namespace app\models;

use Yii;

class RequestWhom extends \yii\db\ActiveRecord {



    public static function tableName() {
        return 'request_whom';
    }



    public function rules() {
        return [
            [['email'], 'required'],
            [['firstname', 'lastname', 'middlename', 'priem'], 'string', 'max' => 255],
            [['email', 'phone'], 'string', 'max' => 128],
            ['kab', 'string', 'max' => 32],
            [['position', 'organization'], 'string', 'max' => 512],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
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



    public function getUserRequests() {
        return $this->hasMany(UserRequest::className(), ['whom_id' => 'id']);
    }



    public function getFio() {
        return $this->lastname . ' ' . $this->firstname . ' ' . $this->middlename;
    }



    public function getFioPosition() {
        return $this->fio . " ($this->position)";
    }



    public function getPositionFio() {
        return $this->position . " ($this->fio)";
    }
}
