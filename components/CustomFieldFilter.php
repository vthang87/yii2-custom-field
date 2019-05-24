<?php
/**
 * Created by PhpStorm.
 * User: devlcs
 * Date: 11/3/16
 * Time: 9:33 AM
 */

namespace vthang87\customfield\components;


use vthang87\customfield\behaviors\CustomFieldBehavior;
use vthang87\customfield\models\CustomField;
use vthang87\customfield\models\CustomFieldValue;
use Yii;
use yii\validators\Validator;

class CustomFieldFilter
{
    
    /**
     * @param $model_name
     * @param $id_field
     * @param $query
     * @param $queryParams
     */
    public static function addFilters($model_name,$id_field,$query,$queryParams)
    {
        if ($queryParams != null && isset($queryParams) && count($queryParams) > 0 && $query != null) {
            $query->leftJoin(CustomFieldValue::tableName() . ' as cfv','cfv.object_id=' . $id_field);
            foreach ($queryParams as $key => $param) {
                $customField = CustomField::findByName($model_name,$key);
                if ($customField != null && isset($param) && !empty($param)) {
                    if (is_array($param)) {
                        $query->andFilterWhere([
                            'and',
                            ['=','custom_field_id',$customField->custom_field_id],
                            ['IN','value',$param],
                        ]);
                    }else {
                        $query->andFilterWhere([
                            'and',
                            ['=','custom_field_id',$customField->custom_field_id],
                            ['LIKE','value',$param],
                        ]);
                    }
                }
            }
        }
    }
}