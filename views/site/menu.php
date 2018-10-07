<?php
    use yii\helpers\Html;
    $this->title = 'Меню';
    $this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<div class="container">
<?php
    $items = $menu->array;
    
    // Ссылки на якорные заголовки меню (только десктоп)
    if (!Yii::$app->mobileDetect->isMobile()){
        $style = "margin-bottom: 30px; padding: 2px; position: sticky; top: 0; z-index: 1; background: #333";
        echo Html::beginTag('div', ['class' => 'col-sm-12 text-center', 'style' => $style]);
        for ($i = 0; $i < count($items); $i++){
            echo Html::a($items[$i]['label'], "#$i", ['style' => 'color: white']) . '&nbsp&nbsp&nbsp&nbsp';
        }
        echo Html::endTag('div');
    }
    
    for ($i = 0; $i < count($items); $i++){
        $class = ($i %2 == 0) ? 'col-sm-6' : 'col-sm-6 col-sm-offset-6';
        echo Html::beginTag('div', ['class' => $class]);
        
        $menuHeader = $items[$i];
        $a = Html::a('', '', ['name' => $i]);
        $header = ($menuHeader['url']) ? Html::a($menuHeader['label'], $menuHeader['url']) : $menuHeader['label'];
        echo Html::tag('h2', $a . $header);
        
        if (is_array($menuHeader['items'])){
            echo Html::beginTag('ul');
            foreach($menuHeader['items'] as $subMenu){
                $element = ($subMenu['url']) ? Html::a($subMenu['label'], $subMenu['url']) : $subMenu['label'];
                echo Html::tag('li', $element);
            }
            echo Html::endTag('ul');
        }
        echo Html::endTag('div');
    }
?>
</div>