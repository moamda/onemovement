<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Member;

/**
 * MemberSearch represents the model behind the search form about `app\models\Member`.
 */
class MemberSearch extends Member
{

    public $firstname;
    public $lastname;
    public $middlename;

    public $contact;
    public $registration_type;
    public $alliance_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'applicant_id', 'alliance_id'], 'integer'],
            [['status', 'created_at', 'firstname', 'lastname', 'middlename', 'contact', 'registration_type', 'alliance_name'], 'safe'],
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
        $query = Member::find()
            ->joinWith(['applicant', 'alliance']);

        // Get current user's alliance
        $allianceId = Alliance::find()
            ->select('id')
            ->where([
                'alliance_leader_user_id' => Yii::$app->user->id,
            ])
            ->scalar();

        // If the user is an Alliance Leader, show only members of their alliance
        if ($allianceId) {
            $query->andWhere([
                'member.alliance_id' => $allianceId,
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'firstname' => SORT_ASC,
                ],
                'attributes' => [
                    'firstname' => [
                        'asc' => ['applicant.personal_information_firstname' => SORT_ASC],
                        'desc' => ['applicant.personal_information_firstname' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        $dataProvider->sort->attributes['firstname'] = [
            'asc' => ['applicant.personal_information_firstname' => SORT_ASC],
            'desc' => ['applicant.personal_information_firstname' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['lastname'] = [
            'asc' => ['applicant.personal_information_lastname' => SORT_ASC],
            'desc' => ['applicant.personal_information_lastname' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['contact'] = [
            'asc' => ['applicant.personal_information_contact' => SORT_ASC],
            'desc' => ['applicant.personal_information_contact' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['middlename'] = [
            'asc' => ['applicant.personal_information_middlename' => SORT_ASC],
            'desc' => ['applicant.personal_information_middlename' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['registration_type'] = [
            'asc' => ['applicant.volunteer_details_registration_type' => SORT_ASC],
            'desc' => ['applicant.volunteer_details_registration_type' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['alliance_name'] = [
            'asc' => ['alliance.organization' => SORT_ASC],
            'desc' => ['alliance.organization' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'applicant_id' => $this->applicant_id,
            'alliance_id' => $this->alliance_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere([
            'like',
            'applicant.personal_information_firstname',
            $this->firstname,
        ]);

        $query->andFilterWhere([
            'like',
            'applicant.personal_information_lastname',
            $this->lastname,
        ]);

        $query->andFilterWhere([
            'like',
            'applicant.personal_information_middlename',
            $this->middlename,
        ]);

        $query->andFilterWhere([
            'like',
            'applicant.personal_information_contact',
            $this->contact,
        ]);

        $query->andFilterWhere([
            'like',
            'applicant.volunteer_details_registration_type',
            $this->registration_type,
        ]);

        $query->andFilterWhere([
            'like',
            'alliance.organization',
            $this->alliance_name,
        ]);

        $query->andFilterWhere([
            'member.status' => $this->status,
        ]);

        return $dataProvider;
    }
}
