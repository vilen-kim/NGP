<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property int $id
 * @property string $image
 * @property string $url
 * @property int $main
 */
class Banners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main'], 'required'],
            [['main'], 'integer'],
            [['image', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Изображение',
            'url' => 'Ссылка',
            'main' => 'Отображать на главной',
        ];
    }
}
