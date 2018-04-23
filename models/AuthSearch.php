<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Auth;

class AuthSearch extends Auth {

    public $description;

    public function rules() {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token'], 'safe'],
            [['description'], 'safe'],
        ];
    }



    public function scenarios() {
        return Model::scenarios();
    }



    public function search($params) {
        $query = Auth::find()->joinWith(['item']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['description'] = [
            'asc' => ['auth_item.description' => SORT_ASC],
            'desc' => ['auth_item.description' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
        ->andFilterWhere(['like', 'auth_key', $this->auth_key])
        ->andFilterWhere(['like', 'password_hash', $this->password_hash])
        ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
        ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
