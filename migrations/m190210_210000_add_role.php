<?php

use yii\db\Migration;

class m190210_210000_add_role extends Migration {



    public function safeUp()
    {
        // Сотрудник - user + работа с приказами
        $am = Yii::$app->authManager;
        $employee = $am->createRole('employee');
        $employee->description = 'Сотрудник';
        $am->add($employee);

        $user = $am->getRole('user');
        $am->addChild($employee, $user);

        $editor = $am->getRole('editor');
        $am->addChild($editor, $employee);
        $am->removeChild($editor, $user);

        $registrator = $am->getRole('registrator');
        $am->addChild($registrator, $employee);
        $am->removeChild($registrator, $user);
    }

    public function safeDown()
    {
        $am = Yii::$app->authManager;
        $employee = $am->getRole('employee');
        $am->remove($employee);
    }
}
