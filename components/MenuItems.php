<?php
namespace app\components;

use Yii;
use yii\base\BaseObject;
use yii\helpers\Json;
use yii\helpers\Html;
use app\models\Menu;

class MenuItems extends BaseObject
{
    public $array;

    public function __construct($config = [])
    {
        $array = null;
        $num = 0;
        
        if (Yii::$app->user->can('user')){
            $array[$num] = [
                'label' => 'Администрирование',
                'url' => null,
                'items' => [
                    [
                        'label' => 'Личный кабинет',
                        'url' => ['kabinet/index'],
                    ]
                ],
            ];
            $num++;
        }
        
        $parents = Menu::find()->where(['parent_id' => 0])->orderBy('position')->all();
        foreach ($parents as $par) {
            $array[$num] = [
                'label' => $par->caption,
                'url' => ($par->page_id) ? ['site/show', 'id' => $par->page_id] : null,
                'linkOptions' => ['style' => 'color: rgb(51,51,51)'],
                'items' => null,
            ];
            
            if ($par->caption == 'Архивные новости'){
                $array[$num]['url'] = null;
                $array[$num]['items'][] = [
                    'label' => 'Архивные новости',
                    'url' => ['site/news'],
                ];
            }
            
            $subMenu = Menu::find()->where(['parent_id' => $par->id])->orderBy('position')->all();
            foreach ($subMenu as $sub) {
                $array[$num]['items'][] = [
                    'label' => $sub->caption,
                    'url' => ($sub->page_id) ? ['site/show', 'id' => $sub->page_id, '#' => $sub->anchor] : null,
                ];
            }
            
            $num++;
        }
        $this->array = $array;
        parent::__construct($config);
    }

    public function init()
    {
    }
    
    public function getItems()
    {
        return $this->array;
    }

    public function getItem($id)
    {
        $arr = $this->array;
        $url = $arr[$id]['url'];
        if (is_array($url)){
            return 'redirect';
        } else {
//            $label = $arr[$id]['label'];
//            $array = Html::tag('h2', $arr[$id]['label'], ['class' => 'text-center', 'style' => 'margin-bottom: 40px']);
            $array = null;
            $subMenu = $arr[$id]['items'];
            if ($subMenu) {
                foreach ($subMenu as $item) {
                    $array .= Html::tag('h4', Html::a($item['label'], $item['url']), ['style' => 'margin-bottom: 20px;']);
                }
            } else {
                $array .= Html::tag('h4', 'Здесь пока нет элементов.');
            }
        }
        return $array;
    }
}