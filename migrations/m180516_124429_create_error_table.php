<?php

use yii\db\Migration;

/**
 * Handles the creation of table `error`.
 */
class m180516_124429_create_error_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('errors', [
            'id'     => 'pk',
            'controller'  => Schema::TYPE_S . ' NOT NULL',
            'text'   => Schema::TYPE_TEXT . ' NOT NULL',
            'date_create' => Schema::TYPE_DATETIME,
            'thumb'  => Schema::TYPE_STRING
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('error');
    }
}
