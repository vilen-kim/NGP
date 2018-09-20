<?php

namespace app\models;

use Yii;

class RequestExecutive extends \yii\db\ActiveRecord {



    public static function tableName() {
        return 'request_executive';
    }



    public function rules() {
        return [
            [['auth_id'], 'required'],
            [['auth_id'], 'integer'],
            [['position'], 'string', 'max' => 512],
            [['kab'], 'string', 'max' => 32],
            [['priem'], 'string', 'max' => 256],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['auth_id' => 'id']],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'auth_id' => 'Auth ID',
            'position' => 'Должность',
            'kab' => 'Кабинет',
            'priem' => 'Прием',
        ];
    }



    public function getAuth() {
        return $this->hasOne(Auth::className(), ['id' => 'auth_id']);
    }



    public function getFioPosition() {
        return $this->auth->profile->fio . ' (' . $this->position . ')';
    }



    public function getPositionFio() {
        return $this->position . ' (' . $this->auth->profile->fio . ')';
    }
}
