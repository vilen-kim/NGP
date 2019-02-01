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
            [['main'], 'required'],
            [['main'], 'integer'],
            [['image', 'url', 'tag'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Изображение',
            'url' => 'Ссылка',
            'main' => 'Отображать на главной',
            'tag' => 'Альтернативный текст',
        ];
    }
}
