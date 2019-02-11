<?php

use yii\db\Migration;

class m190211_224000_alter_table_orders extends Migration {



    public function safeUp() {
        $this->alterColumn('orders', 'caption', $this->string(8192)->notNull());
        $this->alterColumn('orders', 'date', $this->integer()->notNull());
        $this->alterColumn('orders', 'number', $this->string()->notNull());
    }



    public function safeDown() {

    }
}
