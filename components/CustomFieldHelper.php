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
use yii\helpers\ArrayHelper;
use yii\validators\Validator;
use Yii;

class CustomFieldHelper
{
    
    public static function getListOfValue($model_name,$field_name)
    {
        $result      = [];
        $customField = CustomField::findByName($model_name,$field_name);
        if ($customField != null) {
            $result = ArrayHelper::map($customField->getAvailableCustomFieldListOfValues(),'custom_field_list_of_value_id','display_value');
        }
        
        return $result;
    }
    
    public static function getFieldName($name)
    {
        return Yii::$app->getModule('customfield')->formFieldName . '[' . $name . ']';
    }
    
    public static function getSearchFieldName($name)
    {
        return Yii::$app->getModule('customfield')->formSearchFieldName . '[' . $name . ']';
    }
}