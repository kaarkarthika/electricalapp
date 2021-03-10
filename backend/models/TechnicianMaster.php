<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "technician_master".
 *
 * @property integer $auto_id
 * @property string $technician_name
 * @property string $emp_id
 * @property string $address
 * @property string $phone_no
 * @property string $email_id
 * @property string $technician_image
 * @property string $active_status
 * @property string $created_at
 * @property string $updated_at
 */
class TechnicianMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'technician_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['technician_name', 'emp_id', 'address', 'phone_no', 'email_id', 'technician_image', 'active_status'], 'string', 'max' => 255],
            ['email_id', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'technician_name' => 'Technician Name',
            'emp_id' => 'Emp ID',
            'address' => 'Address',
            'phone_no' => 'Phone No',
            'email_id' => 'Email ID',
            'technician_image' => 'Technician Image',
            'active_status' => 'Active Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
