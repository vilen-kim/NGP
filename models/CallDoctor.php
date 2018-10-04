<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class CallDoctor extends \yii\db\ActiveRecord
{


    public static function tableName()
    {
        return 'call_doctor';
    }



    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dateRequest'],
                ]
            ]
        ];
    }



    public function rules()
    {
        return [
            [['auth_id', 'doctor_id', 'closed'], 'integer'],
            [['fio', 'phone', 'text'], 'required'],
            [['text', 'comment'], 'string'],
            [['dateRequest', 'dateWorking'], 'safe'],
            [['fio', 'phone', 'email'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 512],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['auth_id' => 'id']],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['doctor_id' => 'id']],
        ];
    }



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_id' => 'Auth ID',
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'address' => 'Адрес',
            'email' => 'Email',
            'text' => 'Текст обращения',
            'doctor_id' => 'Doctor ID',
            'closed' => 'Закрыто',
            'comment' => 'Комментарий',
            'dateRequest' => 'Дата заявки',
            'dateWorking' => 'Дата закрытия заявки',
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



    public function getPatient()
    {
        $patient = '';
        $patient .= $this->fio ? $this->fio . '<br>' : '';
        $patient .= $this->phone ? $this->phone . '<br>' : '';
        $patient .= $this->address ? $this->address . '<br>' : '';
        $patient .= $this->email ? Html::mailto($this->email) . '<br>' : '';
        return $patient;
    }



    public function getRegistrator()
    {
        $registrator = '';
        $registrator .= $this->dateWorking ? Yii::$app->formatter->asDate($this->dateWorking) . '<br>' : '';
        $registrator .= $this->doctor ? Html::a($this->doctor->fio, ['auth/view', 'id' => $this->doctor->id]) . '<br>' : '';
        $registrator .= $this->comment ? $this->comment . '<br>' : '';
        return $registrator;
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
