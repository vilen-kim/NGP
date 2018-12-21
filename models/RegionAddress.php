<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region_address".
 *
 * @property int $id
 * @property int $street_id
 * @property string $house
 * @property int $house_from
 * @property int $house_to
 * @property int $parity
 */
class RegionAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['street_id'], 'required'],
            [['street_id', 'house_from', 'house_to', 'parity'], 'integer'],
            [['house'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'street_id' => 'Street ID',
            'house' => 'House',
            'house_from' => 'House From',
            'house_to' => 'House To',
            'parity' => 'Parity',
        ];
    }
}
