<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Groups;

/**
 * GroupsSearch represents the model behind the search form about `backend\models\Groups`.
 */
class GroupsSearch extends Groups
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gupload', 'gdownload', 'gtime', 'glimited', 'gprice', 'gstatus'], 'integer'],
            [['groupname', 'gdesc'], 'safe'],
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
        $query = Groups::find();

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
            'gupload' => $this->gupload,
            'gdownload' => $this->gdownload,
            'gtime' => $this->gtime,
            'glimited' => $this->glimited,
            'gprice' => $this->gprice,
            'gstatus' => $this->gstatus,
        ]);

        $query->andFilterWhere(['like', 'groupname', $this->groupname])
            ->andFilterWhere(['like', 'gdesc', $this->gdesc]);

        return $dataProvider;
    }
}
