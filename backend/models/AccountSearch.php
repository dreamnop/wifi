<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Account;

/**
 * AccountSearch represents the model behind the search form about `backend\models\Account`.
 */
class AccountSearch extends Account
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'firstname', 'lastname', 'card_id', 'address', 'mobile', 'dateregis', 'encryption', 'exprie', 'login'], 'safe'],
            [['status', 'muney', 'muney_total'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Account::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'dateregis' => $this->dateregis,
            'status' => $this->status,
            'muney' => $this->muney,
            'muney_total' => $this->muney_total,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'card_id', $this->card_id])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'encryption', $this->encryption])
            ->andFilterWhere(['like', 'exprie', $this->exprie])
            ->andFilterWhere(['like', 'login', $this->login]);

        return $dataProvider;
    }
}
