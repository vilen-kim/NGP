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
            $array[] = [
                'link' => Html::a($par->caption, ['site/show', 'id' => $par->page_id, '#' => $par->anchor]),
                'type' => 'menu',
            ];
            $subMenu = Menu::find()->where(['parent_id' => $par->id])->orderBy('position')->all();
            foreach ($subMenu as $sub) {
                $array[] = [
                    'link' => Html::a($sub->caption, ['site/show', 'id' => $sub->page_id, '#' => $sub->anchor]),
                    'type' => 'submenu',
                ];
            }
        }
        $this->array = $array;
    }

    public function run()
    {
        if ($this->modal){
            echo $this->render('/modals/menu.php', ['array' => $this->array]);
        } else {
            $array = $this->array;
            $begin = false;
            if (isset($array)){
                foreach($array as $arr){
                    if ($arr['type'] == 'menu'){
                        if ($begin){
                            echo '</ul>';
                        }
                        echo '<h4>' . $arr['link'] . '</h4>';
                        $begin = false;
                    } else {
                        if (!$begin){
                            echo '<ul>';
                            $begin = true;
                        }
                        echo '<li>' . $arr['link'] . '</li>';
                    }
                }
            }
        }
    }
}