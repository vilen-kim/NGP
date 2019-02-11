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
            [['date'], 'date'],
            [['number'], 'integer'],
            [['file', 'caption'], 'string', 'max' => 255],
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
