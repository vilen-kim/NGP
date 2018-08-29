<?php
namespace app\components;

use yii\base\BaseObject;
use app\models\Menu;

class MenuItems extends BaseObject
{
    public $array;

    public function __construct()
    {
        $array = null;
        $num = 0;
        $parents = Menu::find()->where(['parent_id' => 0])->orderBy('position')->all();
        foreach ($parents as $par) {
            $array[$num] = [
                'label' => $par->caption,
                'linkOptions' => ['style' => 'color: rgb(51,51,51)'],
                'items' => null,
            ];

            $subMenu = Menu::find()->where(['parent_id' => $par->id])->orderBy('position')->all();
            foreach ($subMenu as $sub) {
                if ($sub->page_id){
                    $array[$num]['items'][] = [
                            'label' => $sub->caption,
                            'url' => ['site/show', 'id' => $sub->page_id, '#' => $sub->anchor],
                    ];
                } else {
                    $array[$num]['items'][] = [
                            'label' => $sub->caption,
                    ];
                }
            }
            $num++;
        }
        $this->array = $array;
    }

    public function init()
    {
        $res[] = $this->array;
        return $res;
    }
}