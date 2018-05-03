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
    private $len = 600;
    private $category;
    private $caption;
    private $text;
    private $image;
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
        
        // Находим первую картинку
        $document = \phpQuery::newDocumentHTML($model->text);
        foreach ($document->find('img[src]') as $element) {
            if ($image = $element->getAttribute('src')){
                $this->image = $image;
                break;
            }
        }
        
        // Очищаем текст от тэгов HTML
        $text = strip_tags($model->purified_text);
        if (mb_strlen($text) > $this->len){
            $temp = mb_substr($text, 0, $this->len);
            $pos = mb_strrpos($temp, '. ');
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
                <div class="col-md-4"><?= Html::img($this->image, ['width' => '100%', 'height' => '100%']) ?></div>
                <div class='col-md-8 text-left' style='padding: 10px;'>
                    <p><b><?= $this->caption ?></b></p>
                    <div class="text-justify" style="overflow: hidden"><?= $this->text ?></div>
                    <?= Html::a('Читать далее...', ['site/show', 'id' => $this->id]) ?>
                </div>
            </div>
        </div>
    <?php
    }
}