<?php

namespace app\models;

use Yii;

class Errors extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'errors';
    }

    public function rules() {
        return [
            [['controller', 'action', 'doing', 'error', 'auth_id'], 'required'],
            [['error'], 'string'],
            [['auth_id'], 'integer'],
            [['controller', 'action'], 'string', 'max' => 255],
            [['doing'], 'string', 'max' => 1024],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'controller' => 'Controller',
            'action' => 'Action',
            'doing' => 'Doing',
            'error' => 'Error',
            'auth_id' => 'Auth ID',
        ];
    }

}
