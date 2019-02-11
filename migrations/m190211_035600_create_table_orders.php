<?php

use yii\db\Migration;

class m190211_035600_create_table_orders extends Migration {



    public function safeUp() {
        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'file' => $this->string(255)->notNull(),
            'caption' => $this->string(255)->notNull(),
            'date' => $this->date()->notNull(),
            'number' => $this->integer()->notNull(),
            'isArchive' => $this->boolean()->defaultValue(0),
        ]);
        $this->createTable('ordersPage', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
        ]);
    }



    public function safeDown() {
        $this->dropTable('orders');
        $this->dropTable('ordersPage');
    }
}
