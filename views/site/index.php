<?php
    use app\components\NewsWidget;
    app\assets\SiteAsset::register($this);
    $this->title = 'Няганская городская поликлиника';
?>
<div class="site-index">
    
    <!-- 1. Функциональные кнопки -->
    <div id="funcButtons" class="row">
        <div class="col-md-4">
            <div id="appointment" class="changeBack">Запись на прием</div>
        </div>
        <div class="col-md-4">
            <div id="call" class="changeBack">Вызов врача на дом</div>
        </div>
        <div class="col-md-4">
            <div id="feedback" class="changeBack">Обратная связь</div>
        </div>
    </div>
    
    <!-- 2. Виджеты новостей и т.д. -->
    <div id="news" class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php
                for ($i = 0; $i < 3; $i++){
                    $res = NewsWidget::widget(['num' => $i, 'len' => 600]);
                    if ($res){
                        echo $res;
                    }
                }
            ?>
        </div>
    </div>
    
</div>