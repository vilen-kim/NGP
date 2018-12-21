<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region_doctor".
 *
 * @property int $id
 * @property string $fio
 * @property int $auth_id
 */
class RegionDoctor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region_doctor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio'], 'required'],
            [['auth_id'], 'integer'],
            [['fio'], 'string', 'max' => 255],
            [['fio'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'auth_id' => 'Auth ID',
        ];
    }
}
