<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Applicant;

/**
 * ApplicantSearch represents the model behind the search form about `app\models\Applicant`.
 */
class ApplicantSearch extends Applicant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'personal_information_age', 'address_details_region', 'address_details_province', 'address_details_city_municipality', 'address_details_brgy', 'employment_information_salary'], 'integer'],
            [['status', 'personal_information_firstname', 'personal_information_lastname', 'personal_information_middlename', 'personal_information_extension_name', 'personal_information_gender', 'personal_information_contact', 'personal_information_birthday', 'personal_information_civil_status', 'address_details_district_street', 'employment_information_occupation', 'employment_information_sector_of_employment', 'emergency_contact_fullname', 'emergency_contact_number', 'emergency_contact_address', 'volunteer_details_registration_type', 'endorsement_sponsor_who_invite', 'document_verification_uplink_id', 'document_verification_uplink_signature'], 'safe'],
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
        $query = Applicant::find();

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
            'personal_information_birthday' => $this->personal_information_birthday,
            'personal_information_age' => $this->personal_information_age,
            'address_details_region' => $this->address_details_region,
            'address_details_province' => $this->address_details_province,
            'address_details_city_municipality' => $this->address_details_city_municipality,
            'address_details_brgy' => $this->address_details_brgy,
            'employment_information_salary' => $this->employment_information_salary,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'personal_information_firstname', $this->personal_information_firstname])
            ->andFilterWhere(['like', 'personal_information_lastname', $this->personal_information_lastname])
            ->andFilterWhere(['like', 'personal_information_middlename', $this->personal_information_middlename])
            ->andFilterWhere(['like', 'personal_information_extension_name', $this->personal_information_extension_name])
            ->andFilterWhere(['like', 'personal_information_gender', $this->personal_information_gender])
            ->andFilterWhere(['like', 'personal_information_contact', $this->personal_information_contact])
            ->andFilterWhere(['like', 'personal_information_civil_status', $this->personal_information_civil_status])
            ->andFilterWhere(['like', 'address_details_district_street', $this->address_details_district_street])
            ->andFilterWhere(['like', 'employment_information_occupation', $this->employment_information_occupation])
            ->andFilterWhere(['like', 'employment_information_sector_of_employment', $this->employment_information_sector_of_employment])
            ->andFilterWhere(['like', 'emergency_contact_fullname', $this->emergency_contact_fullname])
            ->andFilterWhere(['like', 'emergency_contact_number', $this->emergency_contact_number])
            ->andFilterWhere(['like', 'emergency_contact_address', $this->emergency_contact_address])
            ->andFilterWhere(['like', 'volunteer_details_registration_type', $this->volunteer_details_registration_type])
            ->andFilterWhere(['like', 'endorsement_sponsor_who_invite', $this->endorsement_sponsor_who_invite])
            ->andFilterWhere(['like', 'document_verification_uplink_id', $this->document_verification_uplink_id])
            ->andFilterWhere(['like', 'document_verification_uplink_signature', $this->document_verification_uplink_signature]);

        return $dataProvider;
    }
}
