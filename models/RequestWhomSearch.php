<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RequestWhom;

class RequestWhomSearch extends RequestWhom {

    public $fio;

    public function rules() {
        return [
            [['id'], 'integer'],
            [['firstname', 'lastname', 'middlename', 'email', 'position', 'organization', 'phone', 'kab', 'priem'], 'safe'],
            ['fio', 'safe'],
        ];
    }



    public function scenarios() {
        return Model::scenarios();
    }



    public function search($params) {
        $query = RequestWhom::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['fio'] = [
            'asc' => [
                'lastname' => SORT_ASC,
                'firstname' => SORT_ASC,
                'middlename' => SORT_ASC,
            ],
            'desc' => [
                'lastname' => SORT_DESC,
                'firstname' => SORT_DESC,
                'middlename' => SORT_DESC,
            ],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
        ->andFilterWhere(['like', 'lastname', $this->lastname])
        ->andFilterWhere(['like', 'middlename', $this->middlename])
        ->andFilterWhere(['like', 'email', $this->email])
        ->andFilterWhere(['like', 'position', $this->position])
        ->andFilterWhere(['like', 'organization', $this->organization])
        ->andFilterWhere(['like', 'phone', $this->phone])
        ->andFilterWhere(['like', 'kab', $this->kab])
        ->andFilterWhere(['like', 'priem', $this->priem])
        ->andFilterWhere(['like', 'concat(lastname, " ", .firstname, " ", middlename)', $this->fio]);

        return $dataProvider;
    }
}
