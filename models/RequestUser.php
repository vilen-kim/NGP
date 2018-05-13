<?php

namespace app\models;

use Yii;

class RequestUser extends \yii\db\ActiveRecord {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;



    public static function tableName() {
        return 'request_user';
    }



    public function rules() {
        return [
            [['auth_id', 'request_id'], 'required'],
            [['auth_id', 'request_id', 'active'], 'integer'],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['auth_id' => 'id']],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['request_id' => 'id']],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'auth_id' => 'Auth ID',
            'request_id' => 'Request ID',
            'active' => 'Active',
        ];
    }



    public function getAuth() {
        return $this->hasOne(Auth::className(), ['id' => 'auth_id']);
    }



    public function getRequest() {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }
}
