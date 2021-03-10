<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand_mapping".
 *
 * @property integer $autoid
 * @property string $service_id
 * @property string $brands
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class BrandMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $categoryname;
    public static function tableName()
    {
        return 'brand_mapping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['service_id', 'brands'], 'required'],
            [['service_id', 'brands', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'autoid' => 'Autoid',
            'service_id' => 'Service ID',
            'brands' => 'Brands',
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
