<?php
namespace app\components;

use yii\base\BaseObject;
use yii\helpers\Url;
use app\models\Pages;

class News extends BaseObject
{
    public $image;
    public $caption;
    public $text;
    public $id;

    public function __construct($num, $len)
    {
        $model = Pages::find()->limit(1)->offset($num)->where(['in', 'category_id', [2, 3, 4]])->orderBy(['id'=> SORT_DESC])->one();
        if (!$model){
            return false;
        }
        $this->id = $model->id;
        $this->caption = $model->caption;
        
        // Находим первую картинку
        $document = \phpQuery::newDocumentHTML($model->text);
        foreach ($document->find('img[src]') as $element) {
            if ($image = $element->getAttribute('src')){
                $this->image = $image;
                break;
            }
        }
        $this->image = (!$this->image) ? Url::to("/images/emptyNewsImage.jpg") : $this->image;
        
        // Очищаем текст от тэгов HTML
        $text = strip_tags($model->purified_text);
        if (mb_strlen($text) > $len){
            $temp = mb_substr($text, 0, $len);
            $pos = mb_strrpos($temp, '. ');
            $text = mb_substr($temp, 0, $pos + 1);
        }
        $this->text = $text;
    }

    public function init()
    {
        $res['image'] = $this->image;
        $res['caption'] = $this->caption;
        $res['text'] = $this->text;
        $res['id'] = $this->id;
        return $res;
    }
}