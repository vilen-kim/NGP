<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region_link".
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $address_id
 */
class RegionLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doctor_id', 'address_id'], 'required'],
            [['doctor_id', 'address_id'], 'integer'],
            [['doctor_id', 'address_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Doctor ID',
            'address_id' => 'Address ID',
        ];
    }
}
