<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "status_module".
 *
 * @property integer $auto_id
 * @property string $product_id
 * @property string $brand_id
 * @property string $service_type
 * @property string $date_time
 * @property string $address
 * @property string $remarks
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class StatusModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $product_name;
    public $brand_name;
    public $service_name;
    public static function tableName()
    {
        return 'status_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at','phone_number'], 'safe'],
            [['product_id', 'brand_id','date','time', 'service_type', 'technician_id', 'address', 'remarks', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'product_id' => 'Product ID',
            'brand_id' => 'Brand ID',
            'service_type' => 'Service Type',
            'technician_id' => 'Technician Name',
            'address' => 'Address',
            'date' => 'Date',
            'time' => 'Time',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function afterFind() {

      if(isset($this->category->category_name) && !empty($this->category->category_name)){
         $this->product_name = $this->category->category_name;   
       }
      if(isset($this->brand->brands) && !empty($this->brand->brands)){
        $this->brand_name = $this->brand->brands;    
       }
      if(isset($this->service->service_type) && !empty($this->service->service_type)){
        $this->service_name = $this->service->service_type;    
       } 
        parent::afterFind();
    }
    public function getCategory()
    {
        return $this->hasOne(CategoryManagement::className(), ['auto_id' => 'product_id']);
    }
     public function getBrand()
    {
        return $this->hasOne(BrandMapping::className(), ['autoid' => 'brand_id']);
    }
     public function getService()
    {
        return $this->hasOne(ServiceModule::className(), ['auto_id' => 'service_type']);
    }

}
