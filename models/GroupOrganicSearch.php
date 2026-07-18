<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GroupOrganic;

/**
 * GroupOrganicSearch represents the model behind the search form about `app\models\GroupOrganic`.
 */
class GroupOrganicSearch extends GroupOrganic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_leader_user_id', 'group_leader_contact'], 'integer'],
            [['status','group_name', 'group_description', 'created_at'], 'safe'],
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
        $query = GroupOrganic::find();

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
            'group_leader_user_id' => $this->group_leader_user_id,
            'group_leader_contact' => $this->group_leader_contact,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'group_name', $this->group_name])
            ->andFilterWhere(['like', 'group_description', $this->group_description]);

        return $dataProvider;
    }
}
