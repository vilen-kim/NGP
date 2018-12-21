<?php

use yii\db\Migration;

class m181220_233530_regions extends Migration
{
    public function safeUp()
    {
        $this->createTable('region_street', [
            'id' => $this->primaryKey(),
            'caption' => $this->string()->notNull(),
        ]);

        $this->createTable('region_doctor', [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
            'auth_id' => $this->integer(),
        ]);

        $this->createTable('region_address', [
            'id' => $this->primaryKey(),
            'street_id' => $this->integer()->notNull(),
            'house' => $this->string(),
            'house_from' => $this->integer(),
            'house_to' => $this->integer(),
            'parity' => $this->integer(),   // 2 - четные, 1 - нечетные
        ]);

        $this->createTable('region_link', [
            'id' => $this->primaryKey(),
            'doctor_id' => $this->integer()->notNull(),
            'address_id' => $this->integer()->notNull(),
        ]);        
    }

    public function safeDown()
    {
        $this->dropTable('region_street');
        $this->dropTable('region_doctor');
        $this->dropTable('region_address');
        $this->dropTable('region_link');
    }
}
