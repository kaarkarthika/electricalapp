<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customer_master".
 *
 * @property integer $user_id
 * @property string $customer_name
 * @property string $phone
 * @property string $description
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $address
 * @property string $email
 * @property string $active_status
 * @property string $created_at
 * @property string $updated_at
 */
class CustomerMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['created_at', 'updated_at','platform'], 'safe'],
            ['email', 'email'],
            [['description', 'city', 'state', 'country', 'address', 'active_status'], 'string', 'max' => 255],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'customer_name' => 'Customer Name',
            'phone' => 'Phone',
            'description' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'platform' => 'Platform',
            'country' => 'Country',
            'address' => 'Address',
            'email' => 'Email',
            'active_status' => 'Active Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
