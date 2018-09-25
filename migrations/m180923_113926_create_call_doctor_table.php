<?php

use yii\db\Migration;

/**
 * Handles the creation of table `call_doctor`.
 */
class m180923_113926_create_call_doctor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('call_doctor', [
            'id' => $this->primaryKey(),
            'auth_id' => $this->integer(),
            'fio' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'address' => $this->string(),
            'email' => $this->string(),
            'text' => $this->text()->notNull(),
            'doctor_id' => $this->integer(),
            'closed' => $this->boolean(),
            'comment' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('call_doctor');
    }
}
