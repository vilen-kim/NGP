<?php
    use yii\helpers\Html;
    $this->title = 'Меню';
?>

<h1 class="title"><?= $this->title ?></h1>

<div class="row" style="padding: 0 100px">
<?php
    $items = $menu->array;
    
    // Ссылки на якорные заголовки меню
    $style = "margin-bottom: 30px; padding: 2px; position: sticky; top: 0; z-index: 1; background: #333";
    echo "<div class='col-md-6 col-md-offset-6 text-center' style='$style'>";
    for ($i = 0; $i < count($items); $i++){
        echo Html::a($items[$i]['label'], "#$i", ['style' => 'color: white']) . '&nbsp&nbsp&nbsp&nbsp';
    }
    echo '</div>';
    
    for ($i = 0; $i < count($items); $i++){
        echo ($i %2 == 0) ? '<div class="col-md-6">' : '<div class="col-md-6 col-md-offset-6">';
        
        $menuHeader = $items[$i];
        echo '<h2 class="caption">';
            echo Html::a('', '', ['name' => $i]);
            echo ($menuHeader['url']) ? Html::a($menuHeader['label'], $menuHeader['url']) : $menuHeader['label'];
        echo '</h2>';
        
        if (is_array($menuHeader['items'])){
            echo '<ul>';
            foreach($menuHeader['items'] as $subMenu){
                echo '<li>';
                    echo ($subMenu['url']) ? Html::a($subMenu['label'], $subMenu['url']) : $subMenu['label'];
                echo '</li>';
            }
            echo '</ul>';
        }
        echo '</div>';
    }
?>
</div>