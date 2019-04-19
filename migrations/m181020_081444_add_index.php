<?php

use yii\db\Migration;

/**
 * Class m181020_081444_add_index
 */
class m181020_081444_add_index extends Migration
{
    const NAME = '{{%image_manager}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('image_manager_owner_id', self::NAME, 'owner_id');
        $this->createIndex('image_manager_tag', self::NAME, 'tag');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('image_manager_owner_id', self::NAME);
        $this->dropIndex('image_manager_tag', self::NAME);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181020_081444_add_index cannot be reverted.\n";

        return false;
    }
    */
}
