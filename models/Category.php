<?php

namespace app\models;

use Yii;

class Category extends \yii\db\ActiveRecord {



    public static function tableName() {
        return 'category';
    }



    public function rules() {
        return [
            [['caption'], 'required'],
            [['caption'], 'string', 'max' => 128],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'caption' => 'Caption',
        ];
    }



    public function getPages() {
        return $this->hasMany(Pages::className(), ['category_id' => 'id']);
    }
}
