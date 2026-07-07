<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "refbrgy".
 *
 * @property int $id
 * @property string|null $brgyCode
 * @property string|null $brgyDesc
 * @property string|null $regCode
 * @property string|null $provCode
 * @property string|null $citymunCode
 */
class Refbrgy extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'refbrgy';
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
            [['brgyCode', 'brgyDesc', 'regCode', 'provCode', 'citymunCode'], 'default', 'value' => null],
            [['brgyDesc'], 'string'],
            [['brgyCode', 'regCode', 'provCode', 'citymunCode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brgyCode' => 'Brgy Code',
            'brgyDesc' => 'Brgy Desc',
            'regCode' => 'Reg Code',
            'provCode' => 'Prov Code',
            'citymunCode' => 'Citymun Code',
        ];
    }

}
