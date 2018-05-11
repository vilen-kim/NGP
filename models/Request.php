<?php

namespace app\models;

use Yii;

class Request extends \yii\db\ActiveRecord {



    public static function tableName() {
        return 'request';
    }



    public function rules() {
        return [
            [['request_text', 'request_auth_id', 'request_created_at'], 'required'],
            [['request_text', 'answer_text'], 'string'],
            [['request_auth_id', 'request_created_at', 'answer_created_at', 'answer_auth_id'], 'integer'],
            [['answer_auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['answer_auth_id' => 'id']],
            [['request_auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['request_auth_id' => 'id']],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'request_text' => 'Текст обращения',
            'request_auth_id' => 'Кому обращение',
            'request_created_at' => 'Дата обращения',
            'answer_text' => 'Текст ответа',
            'answer_created_at' => 'Дата ответа',
            'answer_auth_id' => 'Автор ответа',
        ];
    }



    public function getAnswerAuth() {
        return $this->hasOne(Auth::className(), ['id' => 'answer_auth_id']);
    }



    public function getRequestAuth() {
        return $this->hasOne(Auth::className(), ['id' => 'request_auth_id']);
    }



    public function getRequestUsers() {
        return $this->hasMany(RequestUser::className(), ['request_id' => 'id']);
    }
}
