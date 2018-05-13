<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use DateTime;
use DateInterval;
use app\models\Pages;

class PagesSearch extends Pages {

    public $fio;
    public $categoryCaption;
    

    public function rules() {
        return [
            [['id', 'category_id', 'auth_id'], 'integer'],
            [['created_at', 'updated_at'], 'date', 'message' => 'Неверный формат даты'],
            [['caption', 'text'], 'safe'],
            [['fio', 'categoryCaption'], 'safe'],
        ];
    }



    public function scenarios() {
        return Model::scenarios();
    }



    public function search($params, $category_id = null) {
        $query = Pages::find()->joinWith(['auth', 'category']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['categoryCaption'] = [
            'asc' => ['category.caption' => SORT_ASC],
            'desc' => ['category.caption' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['fio'] = [
            'asc' => [
                'user_profile.lastname' => SORT_ASC,
                'user_profile.firstname' => SORT_ASC,
                'user_profile.middlename' => SORT_ASC,
            ],
            'desc' => [
                'user_profile.lastname' => SORT_DESC,
                'user_profile.firstname' => SORT_DESC,
                'user_profile.middlename' => SORT_DESC,
            ],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
        ->andFilterWhere(['like', 'pages.caption', $this->caption])
        ->andFilterWhere(['like', 'concat(user_profile.lastname, " ", user_profile.firstname, " ", user_profile.middlename)', $this->fio])
        ->andFilterWhere(['like', 'category.caption', $this->categoryCaption]);
        
        if ($this->created_at){
            $date = DateTime::createFromFormat('d.m.Y', $this->created_at);
            $date->setTime(0,0,0);
            $unixDateStart = $date->getTimeStamp();
            $date->add(new DateInterval('P1D'));
            $date->sub(new DateInterval('PT1S'));
            $unixDateEnd = $date->getTimeStamp();
            $query->andFilterWhere(['between', 'created_at', $unixDateStart, $unixDateEnd]);
        }
        
        if ($this->updated_at){
            $date = DateTime::createFromFormat('d.m.Y', $this->updated_at);
            $date->setTime(0,0,0);
            $unixDateStart = $date->getTimeStamp();
            $date->add(new DateInterval('P1D'));
            $date->sub(new DateInterval('PT1S'));
            $unixDateEnd = $date->getTimeStamp();
            $query->andFilterWhere(['between', 'updated_at', $unixDateStart, $unixDateEnd]);
        }

        return $dataProvider;
    }
}
