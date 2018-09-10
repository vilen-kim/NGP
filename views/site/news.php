<?php
    use yii\helpers\Html;
    $this->title = 'Архивные новости';
?>

<h1><?= $this->title ?></h1>

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