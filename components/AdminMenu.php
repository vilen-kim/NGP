<?php

namespace app\components;

use yii\base\Widget;

class AdminMenu extends Widget
{
    public function run()
    {
        return $this->render('admin-menu');
    }
}