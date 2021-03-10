<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "service_module".
 *
 * @property integer $auto_id
 * @property string $service_id
 * @property string $service_type
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class ServiceModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $categoryname;
    public static function tableName()
    {
        return 'service_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['service_id', 'service_type', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'service_id' => 'Service ID',
            'service_type' => 'Service Type',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function afterFind() {
        
        if(isset($this->service->category_name) && !empty($this->service->category_name)){
         $this->categoryname = $this->service->category_name;  
    }
         parent::afterFind();
    }
    public function getService()
    {
        return $this->hasOne(CategoryManagement::className(), ['auto_id' => 'service_id']);
    }
}
