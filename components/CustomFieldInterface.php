<?php
/**
 * Created by PhpStorm.
 * User: devlcs
 * Date: 11/2/16
 * Time: 1:56 PM
 */

namespace vthang87\customfield\components;


/**
 * Interface CustomFieldAbstract
 * @package common\components
 */
interface CustomFieldInterface
{
    
    /**
     * @param $value
     *
     * @return mixed
     */
    public function setValue($value);
    
    /**
     * @return mixed
     */
    public function getValue();
    
    
    /**
     * @param $custom_field_value_id
     *
     * @return mixed
     */
    public function setCustomFieldValueId($custom_field_value_id);
    
    /**
     * @return mixed
     */
    public function getCustomFieldValueId();
    
    /**
     * @param $custom_field_id
     *
     * @return mixed
     */
    public function setCustomFieldId($custom_field_id);
    
    /**
     * @return mixed
     */
    public function getCustomFieldId();
    
    /**
     * @param $object_id
     *
     * @return mixed
     */
    public function setObjectId($object_id);
    
    /**
     * @return mixed
     */
    public function getObjectId();
    
    /**
     * @param $type
     *
     * @return mixed
     */
    public function setType($type);
    
    /**
     * @return mixed
     */
    public function getType();
    
    
    /**
     * @return mixed
     */
    public function validateValue();
}