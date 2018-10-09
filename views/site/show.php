<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
    app\assets\PageAsset::register($this);
	$this->title = $model->caption;
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="searchOnPage container" style="display: none; position: sticky; top: 0; z-index: 1;">
    <div style="background: #333; width: 200px; padding: 5px; border-radius: 2px;">
        <?= Html::input('text', 'search', '', ['placeholder' => 'Поиск на странице']) ?><br>
        <?= Html::a('Найти', '', ['id' => 'searchOnPage', 'style' => 'color: white;']) ?>
        <span class="count" style="color: white;"></span>
    </div>
</div>

<h1>
    <?php
        $title = $this->title;
        $title .= ' ' . Html::a('<span class="glyphicon glyphicon-search"></span>', '', [
            'style' => 'font-size: 0.7em; color: #008080;',
            'title' => 'Поиск на странице',
            'id'    => 'toggleSearchOnPage',
        ]);
        if (Yii::$app->user->can('editor')) {
            $title .= ' ' . Html::a(
                '<span class="glyphicon glyphicon-pencil"></span>',
                ['pages/update', 'id' => $model->id],
                ['style' => 'font-size: 0.7em; color: #008080;']);
        }
        echo $title;
    ?>
</h1>

<div id="site-show" class="container">
    
    <div class="text-justify">
        <?= $model->purified_text ?>
    </div>

</div>