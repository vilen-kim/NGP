<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use DateTime;
use DateInterval;
use app\models\Pages;

class PagesSearch extends Pages {

    public $username;

    public function rules() {
        return [
            [['id', 'category_id', 'auth_id'], 'integer'],
            [['caption', 'text', 'created_at', 'updated_at'], 'safe'],
            [['username'], 'safe'],
        ];
    }



    public function scenarios() {
        return Model::scenarios();
    }



    public function search($params, $category_id = null) {
        if ($category_id){
            $query = Pages::find()->joinWith(['auth'])->where(['category_id' => $category_id]);
        } else {
            $query = Pages::find()->joinWith(['auth']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['username'] = [
            'asc' => ['auth.username' => SORT_ASC],
            'desc' => ['auth.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
        ->andFilterWhere(['like', 'auth.username', $this->username])
        ->andFilterWhere(['like', 'caption', $this->caption])
        ->andFilterWhere(['like', 'text', $this->text]);
        
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
