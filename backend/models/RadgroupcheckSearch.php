<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Radgroupcheck;

/**
 * RadgroupcheckSearch represents the model behind the search form about `backend\models\Radgroupcheck`.
 */
class RadgroupcheckSearch extends Radgroupcheck
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['groupname', 'attribute', 'op', 'value'], 'safe'],
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
        $query = Radgroupcheck::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'groupname', $this->groupname])
            ->andFilterWhere(['like', 'attribute', $this->attribute])
            ->andFilterWhere(['like', 'op', $this->op])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
