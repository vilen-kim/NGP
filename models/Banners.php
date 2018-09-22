<?php

namespace app\models;

use Yii;



class Banners extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'banners';
    }



    public function rules()
    {
        return [
            [['url', 'image'], 'required'],
            [['url', 'image'], 'string', 'max' => 255],
            ['main', 'boolean'],
        ];
    }



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Ссылка',
            'image' => 'Изображение',
            'main' => 'Отображать на главной',
        ];
    }
}
