<?php

use yii\db\Migration;

class m171022_194912_init extends Migration
{
    const NAME = '{{image_manager}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(self::NAME, [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'base_url' => $this->string(),
            'type' => $this->string(),
            'size' => $this->integer(),
            'name' => $this->string(),
            'created_at' => $this->bigInteger(),
            'updated_at' => $this->bigInteger(),
            'tag' =>  $this->string()->notNull()->defaultValue('undefined')
        ], $tableOptions);

    }

    public function safeDown()
    {
        echo "m171022_194912_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171022_194912_init cannot be reverted.\n";

        return false;
    }
    */
}
