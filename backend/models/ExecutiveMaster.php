<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "executive_master".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $description
 * @property string $service_type
 * @property string $active_status
 * @property string $created_at
 * @property string $updated_at
 */
class ExecutiveMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'executive_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description','phone','username'], 'required'],
            [['username'], 'unique'],
            [['created_at', 'updated_at','email'], 'safe'],
            ['email', 'email'],
            [['city', 'state', 'country'], 'string', 'max' => 255],
            [['active_status'], 'string', 'max' => 25],
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
            'email' => 'Email',
            'phone' => 'Phone',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'description' => 'Description',
            'service_type' => 'Service Type',
            'active_status' => 'Active Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
