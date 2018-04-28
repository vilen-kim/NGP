<?php

namespace app\models;

use Yii;

class Roles extends \yii\db\ActiveRecord {



    public static function tableName() {
        return 'roles';
    }



    public function rules() {
        return [
            [['caption'], 'required'],
            [['caption'], 'string', 'max' => 256],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'caption' => 'Роль',
        ];
    }



    public function getAuths() {
        return $this->hasMany(Auth::className(), ['role_id' => 'id']);
    }
}
