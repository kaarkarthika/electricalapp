<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dropdown_management".
 *
 * @property integer $id
 * @property string $value
 * @property string $key
 * @property string $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property string $ip_address
 * @property string $system_name
 * @property integer $user_id
 * @property string $user_role
 */
class DropdownManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dropdown_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'integer'],
            [['value', 'key', 'is_active', 'ip_address', 'system_name', 'user_role'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'key' => 'Key',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'ip_address' => 'Ip Address',
            'system_name' => 'System Name',
            'user_id' => 'User ID',
            'user_role' => 'User Role',
        ];
    }
}
