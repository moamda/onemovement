<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VerificationSearch represents the search model for the Public Verification Portal.
 * 
 * This search model is dedicated to public member verification and is completely
 * separate from the MemberSearch model used in the admin module.
 * 
 * Features:
 * - Single global keyword search across name fields
 * - Filters for public visibility (APPROVED status + ACTIVE members)
 * - Extensible for future advanced filters
 * - Uses ActiveDataProvider for pagination
 * 
 * @author Your Name
 * @since 1.0
 */
class VerificationSearch extends Model
{
    /**
     * @var string The global search keyword to search across multiple name fields
     */
    public $keyword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keyword'], 'string', 'max' => 255],
            // [['keyword'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'keyword' => 'Search by Name',
        ];
    }

    /**
     * Creates data provider instance with search query applied.
     * 
     * This method performs:
     * 1. Joins with Applicant and Alliance tables for access to name fields
     * 2. Filters only APPROVED applicants (public visibility)
     * 3. Filters only ACTIVE members
     * 4. Performs OR search across all name fields using the keyword
     * 5. Returns paginated results via ActiveDataProvider
     *
     * @param array $params The request parameters (typically from GET)
     * @return ActiveDataProvider The data provider with applied filters
     */
    public function search($params)
    {
        // Build base query with necessary relations
        $query = Member::find()
            ->joinWith(['applicant', 'alliance']);

        // Create data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
                'attributes' => [
                    'firstname' => [
                        'asc' => ['applicant.personal_information_firstname' => SORT_ASC],
                        'desc' => ['applicant.personal_information_firstname' => SORT_DESC],
                    ],
                    'lastname' => [
                        'asc' => ['applicant.personal_information_lastname' => SORT_ASC],
                        'desc' => ['applicant.personal_information_lastname' => SORT_DESC],
                    ],
                    'created_at' => [
                        'asc' => ['member.created_at' => SORT_ASC],
                        'desc' => ['member.created_at' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        // Load and validate the search model
        $this->load($params);
        
        if (!$this->validate()) {
            return $dataProvider;
        }

        // Apply public visibility filters
        $this->applyVisibilityFilters($query);

        // Apply keyword search if provided
        if (!empty($this->keyword)) {
            $this->applyKeywordSearch($query);
        }

        return $dataProvider;
    }

    /**
     * Applies visibility filters to ensure only publicly visible members are returned.
     * 
     * Visibility criteria:
     * - Member must be ACTIVE
     * - Applicant must be APPROVED
     *
     * @param \yii\db\ActiveQuery $query The query to apply filters to
     */
    protected function applyVisibilityFilters($query)
    {
        // Filter for ACTIVE members
        $query->andWhere([
            'member.status' => Member::STATUS_ACTIVE,
        ]);

        // Filter for APPROVED applicants (public visibility)
        $query->andWhere([
            'applicant.status' => Applicant::STATUS_APPROVED,
        ]);
    }

    /**
     * Applies keyword search across all name fields using OR condition.
     * 
     * Searches across:
     * - First Name (personal_information_firstname)
     * - Middle Name (personal_information_middlename)
     * - Last Name (personal_information_lastname)
     * - Extension Name (personal_information_extension_name)
     *
     * @param \yii\db\ActiveQuery $query The query to apply the search to
     */
    protected function applyKeywordSearch($query)
    {
        // Build OR conditions for all name fields
        // NOTE: Do NOT manually add '%' — Yii2's 'like' operator handles wildcards automatically.
        // Manually adding '%' causes Yii2 to escape them, breaking the search.
        $query->andWhere([
            'or',
            ['like', 'applicant.personal_information_firstname', $this->keyword],
            ['like', 'applicant.personal_information_middlename', $this->keyword],
            ['like', 'applicant.personal_information_lastname', $this->keyword],
            ['like', 'applicant.personal_information_extension_name', $this->keyword],
        ]);
    }

    /**
     * Gets the full name of a member from related applicant.
     * 
     * Utility method for displaying member names in search results.
     *
     * @param Member $member The member model
     * @return string The formatted full name
     */
    public static function getFullName($member)
    {
        if (!$member->applicant) {
            return 'Unknown';
        }

        $applicant = $member->applicant;
        $fullName = $applicant->personal_information_firstname;

        if (!empty($applicant->personal_information_middlename)) {
            $fullName .= ' ' . $applicant->personal_information_middlename;
        }

        $fullName .= ' ' . $applicant->personal_information_lastname;

        if (!empty($applicant->personal_information_extension_name) && 
            $applicant->personal_information_extension_name !== 'N/A') {
            $fullName .= ' ' . $applicant->personal_information_extension_name;
        }

        return $fullName;
    }
}
