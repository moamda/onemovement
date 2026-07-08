<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property int $applicant_id
 * @property int $alliance_id
 * @property string $created_at
 */
class Member extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('onemovement_db_system');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['applicant_id', 'alliance_id'], 'required'],
            [['applicant_id', 'alliance_id'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'applicant_id' => 'Applicant ID',
            'alliance_id' => 'Alliance ID',
            'created_at' => 'Approved Date',
        ];
    }

}
