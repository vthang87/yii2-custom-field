<?php

namespace vthang87\customfield\models;

use function count;
use Exception;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "custom_field_group".
 *
 * @property integer       $custom_field_group_id
 * @property string        $object_type
 * @property string        $name
 * @property string        $title
 * @property integer       $position
 * @property integer       $created_at
 * @property integer       $updated_at
 * @property integer       $status
 * @property CustomField[] $customFields
 * @property string        $statusLabel
 */
class CustomFieldGroup extends \yii\db\ActiveRecord{
	const OBJECT_TYPE_CUSTOMER = 'customer';
	const OBJECT_TYPE_ORDER    = 'order';
	const OBJECT_TYPE_TICKET   = 'ticket';
	const OBJECT_TYPE_ADDRESS  = 'address';
	const OBJECT_TYPE_CONTACT  = 'contact';
	
	/**
	 * @inheritdoc
	 */
	public static function tableName(){
		return 'custom_field_group';
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules(){
		return [
			[['position','created_at','updated_at'],'integer'],
			[['object_type','title'],'required'],
			[['object_type','name','title'],'string','max' => 255],
			['status','default','value' => RecordStatus::STATUS_ACTIVE],
			['position','default','value' => 0],
			['status','in','range' => [RecordStatus::STATUS_ACTIVE,RecordStatus::STATUS_INACTIVE]],
			[
				'name',
				'unique',
				'targetAttribute' => ['name','object_type'],
				'message'         => Yii::t('customfield','Name is already used.'),
			],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels(){
		return [
			'custom_field_group_id' => Yii::t('customfield','Custom Field Group ID'),
			'object_type'           => Yii::t('customfield','Object Type'),
			'name'                  => Yii::t('customfield','Name'),
			'title'                 => Yii::t('customfield','Title'),
			'position'              => Yii::t('customfield','Position'),
			'created_at'            => Yii::t('customfield','Created At'),
			'updated_at'            => Yii::t('customfield','Updated At'),
			'status'                => Yii::t('customfield','Status'),
			'statusLabel'           => Yii::t('customfield','Status'),
		];
	}
	
	/**
	 * @return array
	 */
	public function behaviors(){
		return [
			[
				'class'      => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
			],
			[
				'class'         => SluggableBehavior::className(),
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
	public function getCustomFields(){
		return $this->hasMany(CustomField::className(),['custom_field_group_id' => 'custom_field_group_id'])->orderBy(['position' => SORT_ASC]);
	}
	
	/**
	 * Search organizations
	 * @return \yii\data\ActiveDataProvider
	 */
	public function searchCustomFieldGroups(){
		$query = CustomFieldGroup::find();
		
		$name        = Yii::$app->request->get('name','');
		$object_type = Yii::$app->request->get('object_type','');
		
		/**
		 * Validate
		 */
		if(Yii::$app->request->get('validate')){
			$query->andFilterWhere(['=','name',$name]);
			$query->andFilterWhere(['=','object_type',$object_type]);
			
			if(Yii::$app->request->get('custom_field_group_id')){
				$custom_field_group_id = Yii::$app->request->get('custom_field_group_id');
				$query->andFilterWhere(['!=','custom_field_group_id',$custom_field_group_id]);
			}
		}else{
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
	public function getStatusLabel(){
		return RecordStatus::getStatusLabel($this->status);
	}
	
	/**
	 * @param null $object_type
	 *
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getAvailableCustomFieldGroups($object_type = null){
		
		$query = CustomFieldGroup::find()->alias('cfg');
		
		$query->where(['=','cfg.status',RecordStatus::STATUS_ACTIVE])
		      ->andFilterWhere(['=','cfg.object_type',$object_type]);
		
		$query->orderBy(
			['(cfg.position)' => SORT_ASC]);
		
		return $query->all();
	}
	
	/**
	 * @param null $object_type
	 *
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public function getAvailableCustomFields($object_type = null){
		return $this->hasMany(CustomField::className(),['custom_field_group_id' => 'custom_field_group_id'])
		            ->where(['=','status',RecordStatus::STATUS_ACTIVE])
		            ->andWhere(['=','object_type',$object_type])
		            ->orderBy(['(position)' => SORT_ASC])
		            ->all();
	}
	
	
	/**
	 * @param $object_type
	 *
	 * @return null|string
	 */
	public static function getObjectTypeLabel($object_type){
		switch($object_type){
			case self::OBJECT_TYPE_CUSTOMER:
				return Yii::t('customfield','Customer');
				break;
			case self::OBJECT_TYPE_ORDER:
				return Yii::t('customfield','Order');
				break;
			case self::OBJECT_TYPE_TICKET:
				return Yii::t('customfield','Ticket');
				break;
			case self::OBJECT_TYPE_ADDRESS:
				return Yii::t('customfield','Address');
				break;
			case self::OBJECT_TYPE_CONTACT:
				return Yii::t('customfield','Contact');
				break;
			default:
				return null;
		}
	}
	
	/**
	 * @return array
	 */
	public static function getObjectTypeList(){
		return [
			self::OBJECT_TYPE_CUSTOMER => self::getObjectTypeLabel(self::OBJECT_TYPE_CUSTOMER),
			self::OBJECT_TYPE_ORDER    => self::getObjectTypeLabel(self::OBJECT_TYPE_ORDER),
			self::OBJECT_TYPE_TICKET   => self::getObjectTypeLabel(self::OBJECT_TYPE_TICKET),
			self::OBJECT_TYPE_ADDRESS  => self::getObjectTypeLabel(self::OBJECT_TYPE_ADDRESS),
			self::OBJECT_TYPE_CONTACT  => self::getObjectTypeLabel(self::OBJECT_TYPE_CONTACT),
		];
	}
	
	public function afterSave($insert,$changedAttributes){
		parent::afterSave($insert,$changedAttributes); // TODO: Change the autogenerated stub
		
		try{
			$customFields = $this->customFields;
			if($customFields != null && count($customFields) > 0){
				foreach($customFields as $customField){
					$customField->object_type = $this->object_type;
					$customField->save();
				}
			}
		}
		catch(Exception $exception){
			Yii::debug($exception->getMessage());
		}
	}
}

