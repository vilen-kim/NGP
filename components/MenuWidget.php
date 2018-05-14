<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Menu;

class MenuWidget extends Widget
{
    public $array;
    public $modal = false;

    public function init()
    {
        parent::init();
        $array = null;
        $parents = Menu::find()->where(['parent_id' => 0])->orderBy('position')->all();
        foreach ($parents as $par) {
            $subMenu = Menu::find()->where(['parent_id' => $par->id])->orderBy('position')->all();
            $content = '<ul>';
            foreach ($subMenu as $sub) {
                if ($sub->page_id){
                    $content .= '<li>' . Html::a($sub->caption, ['site/show', 'id' => $sub->page_id, '#' => $sub->anchor]) . '</li>';
                } else {
                    $content .= '<li>' . $sub->caption . '</li>';
                }
            }
            $content .= '</ul>';
            $array[] = [
                'label' => $par->caption,
                'content' => $content,
            ];
        }
        $this->array = $array;
    }

    public function run()
    {
        echo $this->render('/modals/menu.php', ['array' => $this->array]);
    }
}