<?php

use yii\db\Migration;

class m160907_100828_custom_field_group extends Migration{
	public function safeUp(){
		$tableOptions = null;
		if($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		$this->createTable('{{%custom_field_group}}',[
			'custom_field_group_id' => $this->primaryKey(),
			'object_type'           => $this->string(255)->notNull(),
			'name'                  => $this->string(255),
			'title'                 => $this->string(255),
			'position'              => $this->integer()->notNull()->defaultValue(0),
			'created_at'            => $this->integer(),
			'updated_at'            => $this->integer(),
			'status'                => $this->integer()->notNull()->defaultValue(1),
		],$tableOptions);
	}
	
	public function safeDown(){
		$this->dropTable('{{%custom_field_group}}');
	}
	
	/*
	// Use safeUp/safeDown to run migration code within a transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
