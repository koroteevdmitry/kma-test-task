<?php

use yii\db\Migration;

/**
 * Class m230419_170405_add_notification_table
 */
class m230419_170405_add_notification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'text' => $this->string()->append('CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL'),
            'status' => $this->integer(),
            'integrator' => $this->integer(),
            'created_at' => $this->dateTime(),
            'send_at' => $this->dateTime()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('notification');
    }
}
