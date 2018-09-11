<?php

use yii\db\Migration;

class m180911_132300_create_table_banners extends Migration {



    public function safeUp() {
        $this->createTable('banners', [
            'id' => $this->integer(),
            'image' => $this->char(255),
            'url' => $this->char(255)
        ]);
        $this->addPrimaryKey('id', 'banners', ['id']);
    }



    public function safeDown() {
        $this->dropTable('banners');
    }
}
