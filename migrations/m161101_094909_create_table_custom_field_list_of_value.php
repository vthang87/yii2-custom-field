<?php

use yii\db\Migration;

class m161101_094909_create_table_custom_field_list_of_value extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%custom_field_list_of_value}}',[
            'custom_field_list_of_value_id' => $this->primaryKey(),
            'custom_field_id'               => $this->integer()->notNull(),
            'display_value'                 => $this->string(),
            'position'                      => $this->integer()->notNull()->defaultValue(0),
            'status'                        => $this->integer()->notNull()->defaultValue(10),
            'created_at'                    => $this->integer()->notNull(),
            'updated_at'                    => $this->integer()->notNull(),
        ],$tableOptions);
    }
    
    public function safeDown()
    {
        $this->dropTable('{{%custom_field_list_of_value}}');
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
