<?php
/**
 * Created by PhpStorm.
 * User: tamtk92
 * Date: 5/28/18
 * Time: 11:53 AM
 */

namespace vthang87\customfield\models;


use Yii;

class RecordStatus{
	/**
	 * id
	 */
	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE   = 10;
	
	/**
	 * @return array
	 */
	public static function getStatusList()
	{
		return [
			self::STATUS_ACTIVE   => self::getStatusLabel(self::STATUS_ACTIVE),
			self::STATUS_INACTIVE => self::getStatusLabel(self::STATUS_INACTIVE),
		];
	}
	
	/**
	 * @param $status
	 *
	 * @return null|string
	 */
	public static function getStatusLabel($status)
	{
		switch($status)
		{
			case self::STATUS_ACTIVE:
				return Yii::t('customfield','Active');
				break;
			case self::STATUS_INACTIVE:
				return Yii::t('customfield','Inactive');
				break;
			default:
				return null;
		}
	}
}