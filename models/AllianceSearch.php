<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Alliance;

/**
 * AllianceSearch represents the model behind the search form about `app\models\Alliance`.
 */
class AllianceSearch extends Alliance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'estimated_members', 'alliance_leader_user_id', 'alliance_leader_contact'], 'integer'],
            [['status','organization', 'area_of_ceverage', 'created_at', 'alliance_leader_position'], 'safe'],
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
        $query = Alliance::find()
            ->orderBy(['organization' => SORT_ASC]);

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
            'estimated_members' => $this->estimated_members,
            'alliance_leader_user_id' => $this->alliance_leader_user_id,
            'alliance_leader_contact' => $this->alliance_leader_contact,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'area_of_ceverage', $this->area_of_ceverage])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'alliance_leader_position', $this->alliance_leader_position]);

        return $dataProvider;
    }
}
