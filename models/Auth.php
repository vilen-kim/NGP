<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\web\IdentityInterface;

class Auth extends ActiveRecord implements IdentityInterface {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;



    public static function tableName() {
        return 'auth';
    }



    public function rules() {
        return [
            [['auth_key', 'password_hash', 'username'], 'required', 'message' => 'Это обязательное поле'],
            [['status'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'username'], 'string', 'max' => 255],
            [['username'], 'unique']
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'auth_key' => 'Ключ авторизации',
            'password_hash' => 'Хэш пароля',
            'password_reset_token' => 'Token для сброса пароля',
            'username' => 'Имя пользователя',
            'status' => 'Статус активации',
        ];
    }



    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }



    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }



    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }



    public static function findByPasswordResetToken($token) {
        return static::findOne(['password_reset_token' => $token]);
    }



    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }



    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }



    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }



    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }



    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }



    public function getId() {
        return $this->getPrimaryKey();
    }



    public function getAuthKey() {
        return $this->auth_key;
    }



    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }
}
