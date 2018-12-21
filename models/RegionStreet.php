<?php

namespace app\models;

use Yii;

class RegionStreet extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'region_street';
    }


    public function rules()
    {
        return [
            [['caption'], 'required'],
            [['caption'], 'string', 'max' => 255],
            [['caption'], 'unique', 'message' => 'Такая улица уже имеется'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'caption' => 'Наименование',
        ];
    }
}
