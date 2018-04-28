<?php

namespace app\models;

use Yii;

class Menu extends \yii\db\ActiveRecord {



    public static function tableName() {
        return 'menu';
    }



    public function rules() {
        return [
            [['caption', 'page_id', 'position'], 'required'],
            [['parent_id', 'page_id','position'], 'integer'],
            [['caption'], 'string', 'max' => 256],
            [['anchor'], 'string', 'max' => 128],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'caption' => 'Наименование',
            'parent_id' => 'ID родителя',
            'page_id' => 'ID страницы',
            'page.caption' => 'Страница',
            'anchor' => 'Якорь',
            'position' => 'Порядок',
        ];
    }



    public function getPage() {
        return $this->hasOne(Pages::className(), ['id' => 'page_id']);
    }
}
