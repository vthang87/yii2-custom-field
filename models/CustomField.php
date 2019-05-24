<?php

namespace vthang87\customfield\models;


use vthang87\customfield\components\CustomFieldCheckbox;
use vthang87\customfield\components\CustomFieldDate;
use vthang87\customfield\components\CustomFieldDateTime;
use vthang87\customfield\components\CustomFieldEmail;
use vthang87\customfield\components\CustomFieldNumber;
use vthang87\customfield\components\CustomFieldRadio;
use vthang87\customfield\components\CustomFieldSelect;
use vthang87\customfield\components\CustomFieldText;
use vthang87\customfield\components\CustomFieldTime;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "custom_field".
 *
 * @property integer                  $custom_field_id
 * @property integer                  $custom_field_group_id
 * @property string                   $object_type
 * @property string                   $name
 * @property string                   $title
 * @property string                   $type
 * @property string                   $options
 * @property integer                  $position
 * @property integer                  $is_required
 * @property integer                  $created_at
 * @property integer                  $updated_at
 * @property integer                  $status
 * @property CustomFieldGroup         $customFieldGroup
 * @property CustomFieldValue         $customFieldValue
 * @property string                   $statusLabel
 * @property CustomFieldListOfValue[] $customFieldListOfValues
 */
class CustomField extends \yii\db\ActiveRecord
{
    
    const  IS_REQUIRED     = 1;
    const  IS_NOT_REQUIRED = 0;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custom_field';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['custom_field_group_id','position','is_required','created_at','updated_at','status'],'integer'],
            [['object_type','title','type'],'required'],
            [['options'],'string'],
            [['object_type','type'],'string','max' => 255],
            [['name','title'],'string','max' => 255],
            ['status','default','value' => RecordStatus::STATUS_ACTIVE],
            ['position','default','value' => 0],
            ['status','in','range' => [RecordStatus::STATUS_ACTIVE,RecordStatus::STATUS_INACTIVE]],
            [
                'name',
                'unique',
                'targetAttribute' => ['name','custom_field_group_id','object_type'],
                'message'         => Yii::t('customfield','Name is already used.'),
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'custom_field_id'       => Yii::t('customfield','Custom Field ID'),
            'custom_field_group_id' => Yii::t('customfield','Custom Field Group ID'),
            'object_type'           => Yii::t('customfield','Object Type'),
            'name'                  => Yii::t('customfield','Name'),
            'title'                 => Yii::t('customfield','Title'),
            'type'                  => Yii::t('customfield','Type'),
            'options'               => Yii::t('customfield','Options'),
            'position'              => Yii::t('customfield','Position'),
            'is_required'           => Yii::t('customfield','Is Required'),
            'created_at'            => Yii::t('customfield','Created At'),
            'updated_at'            => Yii::t('customfield','Updated At'),
            'status'                => Yii::t('customfield','Status'),
        ];
    }
    
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class'      => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            [
                'class'         => SluggableBehavior::class,
                'attribute'     => 'title',
                'slugAttribute' => 'name',
                'immutable'     => true,
                'ensureUnique'  => true,
            ],
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomFieldGroup()
    {
        return $this->hasOne(CustomFieldGroup::class,['custom_field_group_id' => 'custom_field_group_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomFieldValue()
    {
        return $this->hasOne(CustomFieldValue::class,['custom_field_id' => 'custom_field_id']);
    }
    
    /**
     * Search custom fields
     * @return \yii\data\ActiveDataProvider
     */
    public function searchCustomFields()
    {
        $query = CustomField::find();
        
        $name        = Yii::$app->request->get('name','');
        $object_type = Yii::$app->request->get('object_type','');
        
        $custom_field_group_id = Yii::$app->request->get('custom_field_group_id','');
        
        /**
         * Validate
         */
        if (Yii::$app->request->get('validate')) {
            $query->andFilterWhere(['=',CustomField::tableName() . '.name',$name]);
            $query->andFilterWhere(['=',CustomField::tableName() . '.object_type',$object_type]);
            
            if (Yii::$app->request->get('custom_field_id')) {
                $custom_field_id = Yii::$app->request->get('custom_field_id');
                $query->andFilterWhere(['!=',CustomField::tableName() . '.custom_field_id',$custom_field_id]);
            }
        }else {
            $query->andFilterWhere(['=','custom_field_group_id',$custom_field_group_id]);
            
            if (Yii::$app->request->get('status')) {
                $status = Yii::$app->request->get('status');
                $query->andFilterWhere(['=','status',$status]);
            }
            
            $query->andFilterWhere(['like','name',$name]);
            $query->andFilterWhere(['like','object_type',$object_type]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        return $dataProvider;
    }
    
    /**
     * @return null|string
     */
    public function getStatusLabel()
    {
        return RecordStatus::getStatusLabel($this->status);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomFieldListOfValues()
    {
        return $this->hasMany(CustomFieldListOfValue::class,['custom_field_id' => 'custom_field_id'])->orderBy(['position' => SORT_ASC]);
    }
    
    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAvailableCustomFieldListOfValues()
    {
        return $this->hasMany(CustomFieldListOfValue::class,['custom_field_id' => 'custom_field_id'])
                    ->where([
                        '=',
                        'status',
                        RecordStatus::STATUS_ACTIVE,
                    ])
                    ->orderBy(['(position)' => SORT_ASC])
                    ->all();
    }
    
    /**
     * @param $object_id
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getAvailableCustomFieldValues($object_id)
    {
        return $this->hasMany(CustomFieldValue::class,['custom_field_id' => 'custom_field_id'])->where(['=','object_id',$object_id])->all();
    }
    
    /**
     * @return array
     */
    public static function getCustomFieldTypeList()
    {
        return [
            CustomFieldText::TYPE     => self::getCustomFieldTypeLabel(CustomFieldText::TYPE),
            CustomFieldNumber::TYPE   => self::getCustomFieldTypeLabel(CustomFieldNumber::TYPE),
            CustomFieldEmail::TYPE    => self::getCustomFieldTypeLabel(CustomFieldEmail::TYPE),
            CustomFieldSelect::TYPE   => self::getCustomFieldTypeLabel(CustomFieldSelect::TYPE),
            CustomFieldRadio::TYPE    => self::getCustomFieldTypeLabel(CustomFieldRadio::TYPE),
            CustomFieldCheckbox::TYPE => self::getCustomFieldTypeLabel(CustomFieldCheckbox::TYPE),
            CustomFieldDate::TYPE     => self::getCustomFieldTypeLabel(CustomFieldDate::TYPE),
            CustomFieldDateTime::TYPE => self::getCustomFieldTypeLabel(CustomFieldDateTime::TYPE),
            CustomFieldTime::TYPE     => self::getCustomFieldTypeLabel(CustomFieldTime::TYPE),
        ];
    }
    
    /**
     * @param $type
     *
     * @return null|string
     */
    public static function getCustomFieldTypeLabel($type)
    {
        switch ($type) {
            case CustomFieldText::TYPE:
                return Yii::t('customfield','Text');
                break;
            case CustomFieldNumber::TYPE:
                return Yii::t('customfield','Number');
                break;
            case CustomFieldEmail::TYPE:
                return Yii::t('customfield','Email');
                break;
            case CustomFieldSelect::TYPE:
                return Yii::t('customfield','Select');
                break;
            case CustomFieldRadio::TYPE:
                return Yii::t('customfield','Radio');
                break;
            case CustomFieldCheckbox::TYPE:
                return Yii::t('customfield','Checkbox');
                break;
            case CustomFieldDate::TYPE:
                return Yii::t('customfield','Date');
                break;
            case CustomFieldDateTime::TYPE:
                return Yii::t('customfield','Datetime');
                break;
            case CustomFieldTime::TYPE:
                return Yii::t('customfield','Time');
                break;
            default:
                return null;
        }
    }
    
    /**
     * @param $type
     *
     * @return mixed
     */
    public static function getCustomFieldTypeClass($type)
    {
        $class_name = CustomFieldText::class;
        switch ($type) {
            case CustomFieldText::TYPE:
                $class_name = CustomFieldText::class;
                break;
            case CustomFieldNumber::TYPE:
                $class_name = CustomFieldNumber::class;
                break;
            case CustomFieldEmail::TYPE:
                $class_name = CustomFieldEmail::class;
                break;
            case CustomFieldSelect::TYPE:
                $class_name = CustomFieldSelect::class;
                break;
            case CustomFieldRadio::TYPE:
                $class_name = CustomFieldRadio::class;
                break;
            case CustomFieldCheckbox::TYPE:
                $class_name = CustomFieldCheckbox::class;
                break;
            case CustomFieldDate::TYPE:
                $class_name = CustomFieldDate::class;
                break;
            case CustomFieldDateTime::TYPE:
                $class_name = CustomFieldDateTime::class;
                break;
            case CustomFieldTime::TYPE:
                $class_name = CustomFieldTime::class;
                break;
            default:
                $class_name = CustomFieldText::class;
        }
        
        return new $class_name;
    }
    
    /**
     * @param $is_required
     *
     * @return null|string
     */
    public static function getIsRequiredLabel($is_required)
    {
        switch ($is_required) {
            case self::IS_REQUIRED:
                return Yii::t('customfield','Yes');
                break;
            case self::IS_NOT_REQUIRED:
                return Yii::t('customfield','No');
                break;
            default:
                return null;
        }
    }
    
    public static function getListOfValueTypes()
    {
        return [CustomFieldCheckbox::TYPE,CustomFieldSelect::TYPE,CustomFieldRadio::TYPE];
    }
    
    public static function findByName($model_name,$field_name)
    {
        return CustomField::findOne(['object_type' => $model_name,'name' => $field_name]);
    }
}

