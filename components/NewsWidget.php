<?php
namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use app\models\Pages;
use app\models\Category;

class NewsWidget extends Widget
{
    public $num;
    private $len = 1000;
    private $category;
    private $caption;
    private $text;
    private $date;
    private $id;
    private $animate;

    public function init()
    {
        parent::init();
        $model = Pages::find()->limit(1)->offset($this->num)->where(['in', 'category_id', [2, 3, 4]])->orderBy(['id'=> SORT_DESC])->one();
        if (!$model){
            return false;
        }
        $this->category = Category::findOne(['id' => $model->category_id])->caption;
        $this->caption = $model->caption;
        $text = strip_tags($model->text);
        if (mb_strlen($text) > $this->len){
            $temp = mb_substr($text, 1, $this->len);
            $pos = mb_strrpos($temp, '.');
            $text = mb_substr($temp, 0, $pos + 1);
        }
        $this->text = $text;
        $this->date = Yii::$app->formatter->asDate($model->updated_at);
        $this->id = $model->id;
        
        $animated = ['fadeInDownShort', 'fadeInUpShort', 'fadeInLeftShort', 'fadeInRightShort', 'fadeIn'];
        $this->animate = $animated[array_rand($animated)];
    }

    public function run()
    {
    ?>
        <div class="newsWidget animated <?= $this->animate ?>">
            <div class="row">
                <div class='col-md-6 text-left' style='font-size: smaller'><?= $this->category ?></div>
                <div class='col-md-6 text-right' style='font-size: smaller'><?= $this->date ?></div>
            </div>
            <div class='bg-primary text-center' style='padding: 10px;'><b><?= $this->caption ?></b></div>
            <div style='padding: 10px 20px; border: 1px solid whitesmoke;'>
                <?= $this->text ?>
                <?= Html::a('Открыть', ['site/show', 'id' => $this->id]) ?>
            </div>
        </div>
    <?php
    }
}