<?php
/**
 * Created by PhpStorm.
 * User: tamtk92
 * Date: 5/28/18
 * Time: 3:58 PM
 */

namespace vthang87\customfield\widgets\customfieldform;


use vthang87\customfield\models\CustomField;
use vthang87\customfield\models\CustomFieldValue;
use Yii;
use yii\base\Widget;

class CFSearchFieldWidget extends Widget
{
    public $model_name;
    public $form;
    public $name;
    
    public function run()
    {
        $customField = CustomField::findOne(['object_type' => $this->model_name,'name' => $this->name]);
        
        if ($customField != null) {
            $object             = new CustomFieldValue();
            $custom_field_value = null;
            
            return $this->render('_form-field',[
                'form'               => $this->form,
                'object'             => $object,
                'custom_field'       => $customField,
                'custom_field_value' => $custom_field_value,
            ]);
        }else {
            return '<p class="alert alert-danger">' . Yii::t('app','Custom field doesn\'t exist') . '</p>';
        }
    }
}