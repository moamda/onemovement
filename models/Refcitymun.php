<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "refcitymun".
 *
 * @property int $id
 * @property string|null $psgcCode
 * @property string|null $citymunDesc
 * @property string|null $regDesc
 * @property string|null $provCode
 * @property string|null $citymunCode
 */
class Refcitymun extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'refcitymun';
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
            [['psgcCode', 'citymunDesc', 'regDesc', 'provCode', 'citymunCode'], 'default', 'value' => null],
            [['citymunDesc'], 'string'],
            [['psgcCode', 'regDesc', 'provCode', 'citymunCode'], 'string', 'max' => 255],
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
            'citymunDesc' => 'Citymun Desc',
            'regDesc' => 'Reg Desc',
            'provCode' => 'Prov Code',
            'citymunCode' => 'Citymun Code',
        ];
    }

}
