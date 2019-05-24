<?php

namespace vthang87\customfield\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use vthang87\customfield\models\CustomFieldGroup;

/**
 * CustomFieldGroupSearch represents the model behind the search form about `vthang87\customfield\models\CustomFieldGroup`.
 */
class CustomFieldGroupSearch extends CustomFieldGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_field_group_id','position','created_at','updated_at','status'],'integer'],
            [['object_type','name','title'],'safe'],
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
        $query = CustomFieldGroup::find();
        
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
            'custom_field_group_id' => $this->custom_field_group_id,
            'position'              => $this->position,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
            'status'                => $this->status,
        ]);
        
        $query->andFilterWhere(['=','object_type',$this->object_type])
              ->andFilterWhere(['like','name',$this->name])
              ->andFilterWhere(['like','title',$this->title]);
        
        return $dataProvider;
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function customSearch($params)
    {
        $query = CustomFieldGroup::find();
        
        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => false,
            'sort'       => ['defaultOrder' => ['position' => SORT_ASC]],
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
            'custom_field_group_id' => $this->custom_field_group_id,
            'position'              => $this->position,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
            'status'                => $this->status,
        ]);
        
        $query->andFilterWhere(['=','object_type',$this->object_type])
              ->andFilterWhere(['like','name',$this->name])
              ->andFilterWhere(['like','title',$this->title]);
        
        
        return $dataProvider;
    }
}
