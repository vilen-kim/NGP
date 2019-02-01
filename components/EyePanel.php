<?php

namespace app\components;

use yii\base\Widget;

class EyePanel extends Widget
{
    public function run()
    {
        return $this->render('panel');
    }
}