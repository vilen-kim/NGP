<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\web\IdentityInterface;

class Auth extends ActiveRecord implements IdentityInterface {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;



    public static function tableName() {
        return 'auth';
    }



    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ]
            ]
        ];
    }



    public function rules() {
        return [
            [['auth_key', 'password_hash', 'email'], 'required', 'message' => 'Это обязательное поле'],
            [['status'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['email'], 'email'],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'auth_key' => 'Ключ авторизации',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'login_at' => 'Дата последнего входа',
            'password_hash' => 'Хэш пароля',
            'password_reset_token' => 'Token для сброса пароля',
            'email' => 'Электронная почта',
            'status' => 'Статус активации',
        ];
    }



    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }



    public static function findByEmail($email) {
        return static::findOne(['email' => $email]);
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



    public function getAssignment() {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }



    public function getItem() {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name'])->via('assignment');
    }



    public function getDescription() {
        return $this->item['description'];
    }



    public function getProfile() {
        return $this->hasOne(UserProfile::className(), ['auth_id' => 'id']);
    }



    public function getFio() {
        return $this->profile->fio;
    }



    public function getExecutive() {
        return $this->hasOne(RequestExecutive::className(), ['auth_id' => 'id']);
    }
}
