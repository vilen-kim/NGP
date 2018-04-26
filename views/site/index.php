<?php
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
    
</div>