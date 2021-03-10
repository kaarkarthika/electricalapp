<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\StatusModule;

/**
 * StatusModuleSearch represents the model behind the search form about `backend\models\StatusModule`.
 */
class StatusModuleSearch extends StatusModule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auto_id'], 'integer'],
            [['product_id', 'brand_id', 'service_type', 'technician_id', 'address', 'remarks', 'status', 'created_at', 'updated_at','product_name','brand_name','service_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StatusModule::find()->joinWith(['category','brand','service']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'auto_id' => $this->auto_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'category_management.category_name', $this->product_name])
            ->andFilterWhere(['like', 'brand_mapping.brands', $this->brand_name])
            ->andFilterWhere(['like', 'service_module.service_type', $this->service_name])
            ->andFilterWhere(['like', 'technician_id', $this->technician_id])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
