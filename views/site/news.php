<?php
    use yii\helpers\Html;
    app\assets\PageAsset::register($this);
    $this->title = 'Архивные новости';
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="searchOnPage container" style="display: none; position: sticky; top: 0; z-index: 1;">
	<div style="background: #333; width: 200px; padding: 5px; border-radius: 2px;">
	    <?= Html::input('text', 'search', '', ['placeholder' => 'Поиск на странице']) ?><br>
	    <?= Html::a('Найти', '', ['id' => 'searchOnPage', 'style' => 'color: white;']) ?>
		<span class="count" style="color: white;"></span>
	</div>
</div>

<h1><?php
    $title = $this->title;
    $title .= ' ' . Html::a('<span class="glyphicon glyphicon-search"></span>', '', [
        'style' => 'font-size: 0.7em; color: #008080;',
        'title' => 'Поиск на странице',
        'id'    => 'toggleSearchOnPage',
    ]);
    echo $title;
?></h1>

<div class="container">
<?php
    $i = 1;
    foreach($news as $new){
        $text = str_replace(["<p>", "</p>"], "", $new['caption']);
        echo Html::a("$i. $text", ['site/show', 'id' => $new['id']]) . '<br>';
        $i++;
    }
?>
</div>