<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "refprovince".
 *
 * @property int $id
 * @property string|null $psgcCode
 * @property string|null $provDesc
 * @property string|null $regCode
 * @property string|null $provCode
 */
class Refprovince extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'refprovince';
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
            [['psgcCode', 'provDesc', 'regCode', 'provCode'], 'default', 'value' => null],
            [['provDesc'], 'string'],
            [['psgcCode', 'regCode', 'provCode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'psgcCode' => 'Psgc Code',
            'provDesc' => 'Prov Desc',
            'regCode' => 'Reg Code',
            'provCode' => 'Prov Code',
        ];
    }

}
