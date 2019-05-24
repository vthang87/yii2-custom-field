<?php

namespace vthang87\customfield\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "custom_field_list_of_value".
 *
 * @property integer     $custom_field_list_of_value_id
 * @property integer     $custom_field_id
 * @property string      $display_value
 * @property integer     $position
 * @property integer     $created_at
 * @property integer     $updated_at
 * @property integer     $status
 * @property string      $statusLabel
 * @property CustomField $customField
 */
class CustomFieldListOfValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_field_list_of_value';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_field_id'],'required'],
            [['custom_field_id','position','created_at','updated_at','status'],'integer'],
            [['display_value'],'string','max' => 255],
            ['position','default','value' => 0],
            ['status','default','value' => RecordStatus::STATUS_ACTIVE],
            ['status','in','range' => [RecordStatus::STATUS_ACTIVE,RecordStatus::STATUS_INACTIVE]],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'custom_field_list_of_value_id' => Yii::t('customfield','Id'),
            'custom_field_id'               => Yii::t('customfield','Custom Field ID'),
            'display_value'                 => Yii::t('customfield','Display Value'),
            'position'                      => Yii::t('customfield','Position'),
            'status'                        => Yii::t('customfield','Status'),
            'created_at'                    => Yii::t('customfield','Created At'),
            'updated_at'                    => Yii::t('customfield','Updated At'),
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
     * @return null|string
     */
    public function getStatusLabel()
    {
        return RecordStatus::getStatusLabel($this->status);
    }
    
}
