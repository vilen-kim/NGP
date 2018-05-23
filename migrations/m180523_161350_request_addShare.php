<?php

use yii\db\Migration;

class m180523_161350_request_addShare extends Migration {



    public function safeUp() {
        $this->addColumn('request', 'share', $this->boolean());
    }



    public function safeDown() {
        $this->dropColumn('request', 'share');
    }
}
