<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "call_doctor".
 *
 * @property int $id
 * @property int $auth_id
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property string $text
 * @property int $doctor_id
 * @property int $closed
 * @property string $comment
 */
class CallDoctor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'call_doctor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_id', 'doctor_id', 'closed'], 'integer'],
            [['fio', 'phone', 'text'], 'required', 'message' => 'Это обязательное поле'],
            [['text', 'comment'], 'string'],
            [['fio', 'phone', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_id' => 'Auth ID',
            'fio' => 'Fio',
            'phone' => 'Phone',
            'email' => 'Email',
            'text' => 'Text',
            'doctor_id' => 'Doctor ID',
            'closed' => 'Closed',
            'comment' => 'Comment',
        ];
    }
}
