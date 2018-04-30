<?php

namespace app\models;

use Yii;

class UserProfile extends \yii\db\ActiveRecord {



    public static function tableName() {
        return 'user_profile';
    }



    public function rules() {
        return [
            [['auth_id', 'firstname', 'lastname'], 'required'],
            [['auth_id', 'birthdate'], 'integer'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 128],
            [['address', 'organization'], 'string', 'max' => 1024],
            [['phone'], 'string', 'max' => 64],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['auth_id' => 'id']],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'auth_id' => 'Auth ID',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'middlename' => 'Отчество',
            'birthdate' => 'Дата рождения',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'organization' => 'Организация',
        ];
    }



    public function getAuth() {
        return $this->hasOne(Auth::className(), ['id' => 'auth_id']);
    }
}
