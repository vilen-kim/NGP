<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use himiklab\yii2\recaptcha\ReCaptchaValidator;
use app\models\Auth;
use app\models\Request;

class LetterForm extends Model {

    public $request_text;
    public $request_auth_id;
    public $reCaptcha;



    public function rules() {
        $rules = [
            [['request_text', 'request_auth_id'], 'required'],
            ['request_text', 'string'],
            ['request_auth_id', 'integer'],
            [['request_auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['request_auth_id' => 'id']],
            [['reCaptcha'], ReCaptchaValidator::className(), 'secret' => Yii::$app->reCaptcha->secret,
                'uncheckedMessage' => 'Подтвердите, что Вы не бот.',
            ],
        ];
        return $rules;
    }



    public function attributeLabels() {
        return [
            'request_text' => 'Текст обращения',
            'request_auth_id' => 'Кому обращение',
        ];
    }



    public function createLetter() {
        $model = new Request;
        $model->request_text = $this->request_text;
        $model->request_auth_id = $this->request_auth_id;
        if ($model->save()) {
            return $model->id;
        } else {
            var_dump($model->errors);
            return false;
        }
    }
}
