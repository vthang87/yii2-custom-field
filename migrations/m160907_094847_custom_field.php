<?php

use yii\db\Migration;

class m160907_094847_custom_field extends Migration{
	public function safeUp(){
		$tableOptions = null;
		if($this->db->driverName === 'mysql'){
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		$this->createTable('{{%custom_field}}',[
			'custom_field_id'       => $this->primaryKey(),
			'custom_field_group_id' => $this->integer(),
			'object_type'           => $this->string(255)->notNull(),
			'name'                  => $this->string(255)->notNull(),
			'title'                 => $this->string(255)->notNull(),
			'type'                  => $this->string(45)->notNull(),
			'options'               => $this->text(),
			'position'              => $this->integer()->notNull()->defaultValue(0),
			'is_required'           => $this->boolean()->notNull()->defaultValue(0),
			'created_at'            => $this->integer()->notNull(),
			'updated_at'            => $this->integer()->notNull(),
			'status'                => $this->integer()->notNull()->defaultValue(1),
		],$tableOptions);
	}
	
	public function safeDown(){
		$this->dropTable('{{%custom_field}}');
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
