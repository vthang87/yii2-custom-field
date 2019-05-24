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
use yii\validators\Validator;
use Yii;

class CustomFieldValidator extends Validator{
    public function validateAttribute($model,$attribute){
        $errors = [];
        if($model != null && $model[Yii::$app->getModule('customfield')->formFieldName] != null && count($model[Yii::$app->getModule('customfield')->formFieldName]) > 0){
            foreach($model[Yii::$app->getModule('customfield')->formFieldName] as $field){
                $cf = CustomField::getCustomFieldTypeClass($field['type']);
                $cf->setAttributes($field);
                $custom_field = CustomField::findOne($cf->getCustomFieldId());
                if($custom_field != null){
                    $result_message = $cf->validateValue();
                    if($result_message){
                        $message  = $custom_field->title . ': ' . $result_message;
                        $error    = [
                            'customFields' => $message,
                        ];
                        $errors[] = $error;
                    }
                    
                    if($custom_field->is_required == true && $cf->getValue() == null){
                        $message  = $custom_field->title . ': ' . \Yii::t('customfield','Is required.');
                        $error    = [
                            'customFields' => $message,
                        ];
                        $errors[] = $error;
                    }
                }
            }
        }
        if(count($errors) > 0){
            $model->addErrors($errors);
        }
    }
}