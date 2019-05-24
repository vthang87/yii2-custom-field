<?php
/**
 * Created by PhpStorm.
 * User: devlcs
 * Date: 11/2/16
 * Time: 4:42 PM
 */

namespace vthang87\customfield\components;


use yii\base\Model;

class CustomFieldRadio extends Model implements CustomFieldInterface
{
    const TYPE = 'radio';
    public $custom_field_value_id = null;
    public $custom_field_id       = null;
    public $object_id             = null;
    public $value                 = null;
    public $type                  = null;
    
    public function rules()
    {
        return [
            [
                [
                    'custom_field_value_id',
                    'custom_field_id',
                    'object_id',
                    'value',
                    'type',
                ],
                'safe',
            ],
        ];
    }
    
    public function validateValue()
    {
        $message = null;
        
        return $message;
    }
    
    public function getValue()
    {
        // TODO: Implement getValue() method.
        return $this->value;
    }
    
    public function getCustomFieldValueId()
    {
        // TODO: Implement getCustomFieldValueId() method.
        return $this->custom_field_value_id;
    }
    
    public function setValue($value)
    {
        // TODO: Implement setValue() method.
        $this->value = $value;
    }
    
    public function setCustomFieldValueId($custom_field_value_id)
    {
        // TODO: Implement setCustomFieldValueId() method.
        $this->custom_field_value_id = $custom_field_value_id;
    }
    
    /**
     * @param $custom_field_id
     *
     * @return mixed
     */
    public function setCustomFieldId($custom_field_id)
    {
        // TODO: Implement setCustomFieldId() method.
        $this->custom_field_id = $custom_field_id;
    }
    
    /**
     * @return mixed
     */
    public function getCustomFieldId()
    {
        // TODO: Implement getCustomFieldId() method.
        return $this->custom_field_id;
    }
    
    /**
     * @param $object_id
     *
     * @return mixed
     */
    public function setObjectId($object_id)
    {
        // TODO: Implement setObjectId() method.
        $this->object_id = $object_id;
    }
    
    /**
     *
     * @return mixed
     */
    public function getObjectId()
    {
        // TODO: Implement getObjectId() method.
        return $this->object_id;
    }
    
    /**
     * @param $type
     *
     * @return mixed
     */
    public function setType($type)
    {
        // TODO: Implement setType() method.
        $this->type = $type;
    }
    
    /**
     * @return mixed
     */
    public function getType()
    {
        // TODO: Implement getType() method.
        return $this->type;
    }
}