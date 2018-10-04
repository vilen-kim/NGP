<?php

use yii\db\Migration;

class m181004_082813_table_call_Doctor_add_column_date extends Migration
{
    public function safeUp()
    {
        $this->addColumn('call_doctor', 'dateRequest', $this->integer());
        $this->addColumn('call_doctor', 'dateWorking', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('call_doctor', 'dateRequest');
        $this->dropColumn('call_doctor', 'dateWorking');
    }
}
