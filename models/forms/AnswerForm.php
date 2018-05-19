<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

class AnswerForm extends Model {

    public $answer_text;



    public function rules() {
        $rules = [
            ['answer_text', 'required'],
            ['answer_text', 'string'],
        ];
        return $rules;
    }



    public function attributeLabels() {
        return [
            'answer_text' => 'Текст ответа',
        ];
    }



    public function createAnswer($model) {
        $model->answer_text = $this->answer_text;
        $model->touch('answer_created_at');
        $model->answer_auth_id = Yii::$app->user->id;
        if ($model->save()) {
            return $model->id;
        } else {
            Yii::error('Ошибка создания ответа на обращение', 'request_category');
            return false;
        }
    }
}
