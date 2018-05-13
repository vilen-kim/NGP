<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use DateTime;
use DateInterval;
use app\models\Request;

class RequestSearch extends Request {



    public function rules() {
        return [
            ['id', 'integer'],
            [['request_created_at', 'answer_created_at'], 'date', 'message' => 'Неверный формат даты'],
            [['request_text', 'answer_text', 'request_auth_id', 'answer_auth_id'], 'safe'],
        ];
    }



    public function scenarios() {
        return Model::scenarios();
    }



    public function search($params) {
        $query = Request::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->request_created_at) {
            $date = DateTime::createFromFormat('d.m.Y', $this->request_created_at);
            $date->setTime(0, 0, 0);
            $unixDateStart = $date->getTimeStamp();
            $date->add(new DateInterval('P1D'));
            $date->sub(new DateInterval('PT1S'));
            $unixDateEnd = $date->getTimeStamp();
            $query->andFilterWhere(['between', 'request_created_at', $unixDateStart, $unixDateEnd]);
        }

        if ($this->answer_created_at) {
            $date = DateTime::createFromFormat('d.m.Y', $this->answer_created_at);
            $date->setTime(0, 0, 0);
            $unixDateStart = $date->getTimeStamp();
            $date->add(new DateInterval('P1D'));
            $date->sub(new DateInterval('PT1S'));
            $unixDateEnd = $date->getTimeStamp();
            $query->andFilterWhere(['between', 'answer_created_at', $unixDateStart, $unixDateEnd]);
        }

        $query->andFilterWhere(['like', 'request_text', $this->request_text])
        ->andFilterWhere(['like', 'answer_text', $this->answer_text]);

        return $dataProvider;
    }
}
