<?php
use yii\helpers\Html;
app\assets\KabinetAsset::register($this);
$this->title = 'Личный кабинет';
if (!Yii::$app->mobileDetect->isMobile()){
    $image = ['height' => 70];
    $style = 'col-sm-2 text-center showText';
    $div = 'row';
} else {
    $image = ['width' => 30, 'style' => 'margin: 0 10px 10px 0'];
    $style = '';
    $div = '';
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="kabinet-index container">
    <div class="col-md-3">
        <?= \app\components\AdminMenu::widget() ?>
    </div>

</div>