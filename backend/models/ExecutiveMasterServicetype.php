<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "executive_master_servicetype".
 *
 * @property integer $id
 * @property string $name
 * @property string $service_type
 * @property string $exe_id
 * @property string $created_at
 * @property string $updated_at
 */
class ExecutiveMasterServicetype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'executive_master_servicetype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at','exe_id'], 'safe'],
            [['name', 'service_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'service_type' => 'Service Type',
            'exe_id' => 'Exe ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
