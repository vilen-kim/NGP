<?php

use yii\db\Migration;

class m190212_031100_add_role_order_editor extends Migration {



    public function safeUp()
    {
        // Роль - редактор приказов
        $am = Yii::$app->authManager;
        $orderEditor = $am->createRole('orderEditor');
        $orderEditor->description = 'Редактор приказов';
        $am->add($orderEditor);

        $employee = $am->getRole('employee');
        $am->addChild($orderEditor, $employee);

        $manager = $am->getRole('manager');
        $am->addChild($manager, $orderEditor);
    }

    public function safeDown()
    {
        $am = Yii::$app->authManager;
        $orderEditor = $am->getRole('orderEditor');
        $am->remove($orderEditor);
    }
}
