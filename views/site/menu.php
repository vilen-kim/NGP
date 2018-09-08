<?php
    use yii\helpers\Html;
    $this->title = 'Меню';
?>

<h1 class="title"><?= $this->title ?></h1>

<div class="row" style="padding: 0 100px">
<?php
    $items = $menu->array;
    
    // Ссылки на якорные заголовки меню
    echo '<div class="col-md-6 col-md-offset-6" style="margin-bottom: 30px">';
    for ($i = 0; $i < count($items); $i++){
        echo Html::a($items[$i]['label'], "#$i") . '&nbsp&nbsp&nbsp&nbsp';
    }
    echo '</div>';
    
    for ($i = 0; $i < count($items); $i++){
        echo ($i %2 == 0) ? '<div class="col-md-6">' : '<div class="col-md-6 col-md-offset-6">';
        
        $menuHeader = $items[$i];
        echo '<h2>';
            echo Html::a('', '', ['name' => $i]);
            echo ($menuHeader['url']) ? Html::a($menuHeader['label'], $menuHeader['url']) : $menuHeader['label'];
        echo '</h2>';
        
        if (is_array($menuHeader['items'])){
            echo '<ul>';
            foreach($menuHeader['items'] as $subMenu){
                echo '<li><h4>';
                    echo ($subMenu['url']) ? Html::a($subMenu['label'], $subMenu['url']) : $subMenu['label'];
                echo '</h4></li>';
            }
            echo '</ul>';
        }
        echo '</div>';
    }
?>
</div>