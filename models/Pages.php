<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Pages extends \yii\db\ActiveRecord {



    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }



    public static function tableName() {
        return 'pages';
    }



    public function rules() {
        return [
            [['caption', 'text', 'category_id', 'auth_id'], 'required', 'message' => 'Это обязательное поле'],
            [['text'], 'string'],
            [['category_id', 'auth_id'], 'integer'],
            [['caption'], 'string', 'max' => 1024],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['auth_id' => 'id']],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'caption' => 'Заголовок',
            'text' => 'Текст',
            'category_id' => 'Категория',
            'created_at' => 'Создание',
            'updated_at' => 'Изменение',
            'username' => 'Автор',
            'category.caption' => 'Категория',
        ];
    }



    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }



    public function getAuth() {
        return $this->hasOne(Auth::className(), ['id' => 'auth_id']);
    }



    public function getUsername() {
        return $this->auth->username;
    }
}
