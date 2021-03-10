<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "task_management".
 *
 * @property integer $task_id
 * @property string $task_name
 * @property integer $customer_id
 * @property integer $excutive_id
 * @property string $service_date
 * @property string $description
 * @property string $reason
 * @property string $created_at
 * @property string $updated_at
 */
class TaskManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $customername;
     public $excutive_name;
     public $service_type;
    public static function tableName()
    {
        return 'task_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'excutive_id','service_date','task_name'], 'required'],
            [['customer_id', 'excutive_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['description', 'reason'], 'string'],
            [['task_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'task_name' => 'Service Type',
            'customer_id' => 'Customer Name',
            'excutive_id' => 'Excutive Name',
            'service_date' => 'Appointment Date & Time',
            'description' => 'Description',
            'reason' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

public function afterFind() {
if(isset($this->lead)){
$this->customername = $this->lead->customer_name; 
}else{
$this->customername="-";
}
if(isset($this->lead2)){
$this->excutive_name = $this->lead2->name; 
}else{
$this->excutive_name="-";
}
if(isset($this->lead3)){
$this->service_type = $this->lead3->category_name; 
}else{
$this->service_type="-";
}
}
public function getLead()
{
//TansiLeadManagement
return $this->hasOne(CustomerMaster::className(), ['user_id' =>'customer_id']);
}
public function getLead2()
{
//TansiLeadManagement
return $this->hasOne(ExecutiveMaster::className(), ['id' =>'excutive_id']);
}
public function getLead3()
{
//TansiLeadManagement
return $this->hasOne(CategoryManagement::className(), ['auto_id' =>'task_name']);
}



}
