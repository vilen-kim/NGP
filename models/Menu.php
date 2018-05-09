<?php

namespace app\models;

use Yii;

class Menu extends \yii\db\ActiveRecord {



    public static function tableName() {
        return 'menu';
    }



    public function rules() {
        return [
            [['caption', 'position'], 'required'],
            [['parent_id', 'page_id','position'], 'integer'],
            [['caption'], 'string', 'max' => 256],
            [['anchor'], 'string', 'max' => 128],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'caption' => 'Наименование',
            'parent_id' => 'Меню-родитель',
            'page_id' => 'Страница',
            'page.caption' => 'Страница',
            'anchor' => 'Якорь',
            'position' => 'Порядок',
        ];
    }



    public function getPage() {
        return $this->hasOne(Pages::className(), ['id' => 'page_id']);
    }
}
