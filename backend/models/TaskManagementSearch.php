<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TaskManagement;

/**
 * TaskManagementSearch represents the model behind the search form about `backend\models\TaskManagement`.
 */
class TaskManagementSearch extends TaskManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'customer_id', 'excutive_id'], 'integer'],
            [['task_name', 'service_date', 'description', 'reason', 'created_at', 'updated_at','customername','excutive_name','service_type'], 'safe'],
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
        $query = TaskManagement::find()->where(['IN','reason',['Started','Asigned']])
         ->joinWith(['lead'])
         ->joinWith(['lead2'])
         ->joinWith(['lead3']);
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
            'task_id' => $this->task_id,
           // 'customer_id' => $this->customer_id,
            'excutive_id' => $this->excutive_id,
            'service_date' => $this->service_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'task_name', $this->task_name])
        ->andFilterWhere(['like', 'description', $this->description])
        ->andFilterWhere(['like', 'customer_master.customer_name', $this->customername])
        ->andFilterWhere(['like', 'executive_master.name', $this->excutive_name])
        ->andFilterWhere(['like', 'category_management.category_name', $this->service_type])
        ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
