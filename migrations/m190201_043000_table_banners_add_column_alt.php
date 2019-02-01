<?php

use yii\db\Migration;

class m190201_043000_table_banners_add_column_alt extends Migration
{
    public function safeUp()
    {
        $this->addColumn('banners', 'tag', $this->string(255)->null());
    }

    public function safeDown()
    {
        $this->dropColumn('banners', 'tag');
    }
}
