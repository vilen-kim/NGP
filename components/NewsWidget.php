<?php
namespace app\components;

use yii\base\Widget;
use app\models\Pages;
use app\models\Category;

class NewsWidget extends Widget
{
    public $num;
    public $len = 600;
    private $category;
    private $caption;
    private $text;

    public function init()
    {
        parent::init();
        $model = Pages::find()->limit(1)->offset($this->num)->where(['in', 'category_id', [2, 3, 4]])->orderBy(['id'=> SORT_DESC])->one();
        if (!$model){
            return false;
        }
        $this->category = Category::findOne(['id' => $model->category_id])->caption;
        $this->caption = $model->caption;
        $temp = mb_substr($model->text, 0, $this->len);
        $pos = mb_strrpos($temp, '.');
        $this->text = mb_substr($temp, 0, $pos + 1);
    }

    public function run()
    {
        echo '<div>';
        echo "<p><em style='font-size: smaller;'>$this->category</em></p>";
        echo "<p class='bg-success text-center' style='padding: 20px;'><b>$this->caption</b></p>";
        echo $this->text;
        echo '</div>';
    }
}