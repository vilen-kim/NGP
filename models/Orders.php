<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $file
 * @property string $caption
 * @property string $date
 * @property int $number
 * @property int $isArchive
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file', 'caption', 'number', 'date'], 'required'],
            [['date'], 'integer'],
            [['file', 'number'], 'string', 'max' => 255],
            ['caption', 'string', 'max' => 8192],
            [['isArchive'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'Файл',
            'caption' => 'Название',
            'date' => 'Дата',
            'number' => 'Номер',
            'isArchive' => 'В архиве',
        ];
    }
}
