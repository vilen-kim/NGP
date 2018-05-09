<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Auth;

class AuthSearch extends Auth {

    public $fio;
    public $description;
    public $executive;

    public function rules() {
        return [
            [['id', 'status'], 'integer'],
            [['email', 'auth_key', 'password_hash', 'password_reset_token'], 'safe'],
            [['description', 'fio', 'executive'], 'safe'],
        ];
    }



    public function scenarios() {
        return Model::scenarios();
    }



    public function search($params) {
        $query = Auth::find()->joinWith(['item', 'profile', 'executive']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['description'] = [
            'asc' => ['auth_item.description' => SORT_ASC],
            'desc' => ['auth_item.description' => SORT_DESC],
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

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
        ->andFilterWhere(['like', 'auth_key', $this->auth_key])
        ->andFilterWhere(['like', 'password_hash', $this->password_hash])
        ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
        ->andFilterWhere(['like', 'description', $this->description])
        ->andFilterWhere(['like', 'concat(user_profile.lastname, " ", user_profile.firstname, " ", user_profile.middlename)', $this->fio]);

        return $dataProvider;
    }
}
