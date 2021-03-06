<?php

namespace vthang87\customfield\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use vthang87\customfield\models\CustomFieldListOfValue;

/**
 * CustomFieldListOfValueSearch represents the model behind the search form about `vthang87\customfield\models\CustomFieldListOfValue`.
 */
class CustomFieldListOfValueSearch extends CustomFieldListOfValue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_field_list_of_value_id','custom_field_id','position','created_at','updated_at','status'],'integer'],
            [['display_value'],'safe'],
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
        $query = CustomFieldListOfValue::find();
        
        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
        
        if( !$this->validate())
        {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'custom_field_list_of_value_id' => $this->custom_field_list_of_value_id,
            'custom_field_id'               => $this->custom_field_id,
            'position'                      => $this->position,
            'created_at'                    => $this->created_at,
            'updated_at'                    => $this->updated_at,
            'status'                        => $this->status,
        ]);
        
        $query->andFilterWhere(['like','display_value',$this->display_value]);
        
        return $dataProvider;
    }
}
