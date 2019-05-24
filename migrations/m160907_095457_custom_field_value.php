<?php

use yii\db\Migration;

class m160907_095457_custom_field_value extends Migration{
    public function safeUp(){
        $tableOptions = null;
        if($this->db->driverName === 'mysql'){
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%custom_field_value}}',[
            'custom_field_value_id' => $this->primaryKey(),
            'custom_field_id'       => $this->integer()->notNull(),
            'object_id'             => $this->integer()->notNull(),
            'value'                 => $this->text(),
            'created_at'            => $this->integer()->notNull(),
            'updated_at'            => $this->integer()->notNull(),
        ],$tableOptions);
    }
    
    public function safeDown(){
        $this->dropTable('{{%custom_field_value}}');
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
