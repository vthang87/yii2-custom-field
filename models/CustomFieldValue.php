<?php

namespace vthang87\customfield\models;

use Exception;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "custom_field_value".
 *
 * @property integer                $custom_field_value_id
 * @property integer                $custom_field_id
 * @property integer                $object_id
 * @property resource               $value
 * @property integer                $created_at
 * @property integer                $updated_at
 * @property CustomField            $customField
 * @property CustomFieldListOfValue $customFieldListOfValue
 */
class CustomFieldValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_field_value';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_field_id','object_id'],'required'],
            [['custom_field_id','object_id','created_at','updated_at'],'integer'],
            [['value'],'string'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'custom_field_value_id' => Yii::t('customfield','Custom Field Value ID'),
            'custom_field_id'       => Yii::t('customfield','Custom Field ID'),
            'object_id'             => Yii::t('customfield','Object ID'),
            'value'                 => Yii::t('customfield','Value'),
            'created_at'            => Yii::t('customfield','Created At'),
            'updated_at'            => Yii::t('customfield','Updated At'),
        ];
    }
    
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomField()
    {
        return $this->hasOne(CustomField::className(),['custom_field_id' => 'custom_field_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomFieldListOfValue()
    {
        return $this->hasOne(CustomFieldListOfValue::className(),['custom_field_list_of_value_id' => 'value'])->where([
            '=',
            'custom_field_id',
            $this->custom_field_id,
        ]);
    }
    
    /**
     * @param $custom_fields
     * @param $object_id
     */
    public static function saveCustomFieldValue($custom_fields,$object_id)
    {
        if (isset($custom_fields)) {
            foreach ($custom_fields as $field) {
                if (isset($field['type'])) {
                    $object = CustomField::getCustomFieldTypeClass($field['type']);
                    $object->setAttributes($field);
                    
                    try{
                        if (isset($field['is_array']) && $field['is_array'] == true) {
                            self::deleteOldValues($object->getCustomFieldId(),$object_id);
                        }
                        
                        if ($object->getValue() != null || is_array($object->getValue())) {
                            if (is_array($object->getValue())) {
                                if (count($object->getValue()) > 0) {
                                    foreach ($object->getValue() as $value) {
                                        self::saveValue($object_id,$object->getCustomFieldId(),null,$value);
                                    }
                                }
                            }else {
                                self::saveValue($object_id,$object->getCustomFieldId(),$object->getCustomFieldValueId(),$object->getValue());
                            }
                        }
                    }catch (Exception $exception){
                        Yii::debug($exception->getMessage());
                    }
                }
            }
        }
    }
    
    private static function saveValue($object_id,$custom_field_id,$custom_field_value_id,$value)
    {
        $custom_field_value = new CustomFieldValue();
        if ($custom_field_value_id != null) {
            $custom_field_value = CustomFieldValue::findOne($custom_field_value_id);
        }
        $custom_field_value->custom_field_id = $custom_field_id;
        $custom_field_value->value           = $value;
        $custom_field_value->object_id       = $object_id;
        $custom_field_value->save();
    }
    
    private static function deleteOldValues($custom_field_id,$object_id)
    {
        try{
            CustomFieldValue::deleteAll(['and',['=','custom_field_id',$custom_field_id],['=','object_id',$object_id]]);
        }catch (Exception $exception){
            Yii::debug($exception->getMessage());
        }
    }
}

