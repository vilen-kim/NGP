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
 * @property string $address
 * @property string $email
 * @property string $text
 * @property int $doctor_id
 * @property int $closed
 * @property string $comment
 *
 * @property Auth $auth
 * @property Auth $doctor
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
            [['fio', 'phone', 'text'], 'required'],
            [['text', 'comment'], 'string'],
            [['fio', 'phone', 'email'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 512],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['auth_id' => 'id']],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['doctor_id' => 'id']],
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
            'fio' => 'ФИО',
            'phone' => 'Номер телефона',
            'address' => 'Адрес',
            'email' => 'Электронная почта',
            'text' => 'Описание',
            'doctor_id' => 'Кто закрыл заявку',
            'closed' => 'Статус заявки',
            'comment' => 'Комментарий',
        ];
    }



    public function getAuth()
    {
        return $this->hasOne(Auth::className(), ['id' => 'auth_id']);
    }



    public function getDoctor()
    {
        return $this->hasOne(Auth::className(), ['id' => 'doctor_id']);
    }



    public function sendEmail() {
        $res = Yii::$app->mailer->compose(['html' => 'callCenter'], ['model' => $this])
            ->setTo(Yii::$app->params['callCenter'])
            ->setSubject("Регистрация вызова врача на дом")
            ->send();
        if ($res){
            if ($this->email){
                $res = Yii::$app->mailer->compose(['html' => 'callPatient'], ['model' => $this])
                    ->setTo($this->email)
                    ->setSubject("Регистрация вызова врача на дом")
                    ->send();
            }
            return true;
        } else {
            return false;
        }
    }
}
