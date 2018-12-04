<?php
    use yii\helpers\Html;
    app\assets\EyeAsset::register($this);
?>

<div id="eyePanel">

        <div style="margin-top: 14px;">
            <?= Html::a('А', '', [
                'id'    => 'fontSizeDown',
                'style' => 'font-size: 16px; font-weight: bold; text-decoration: none;',
                'title' => 'Уменьшить шрифт', 
            ]) ?>
        </div>

        <div style="margin-top: 5px;">
            <?= Html::a('А', '', [
                'id'    => 'fontSizeUp',
                'style' => 'font-size: 24px; font-weight: bold; text-decoration: none;',
                'title' => 'Увеличить шрифт',
            ]) ?>
        </div>

        <div style="margin-top: 9px;">
            <?= Html::a('А', '', [
                'id'    => 'whiteOnBlack',
                'style' => 'font-size: 18px; font-weight: bold; text-decoration: none; background: black; color: white; padding: 0 6px;',
                'title' => 'Белый шрифт на черном фоне',
            ]) ?>
        </div>

        <div style="margin-top: 9px;">
            <?= Html::a('А', '', [
                'id'    => 'whiteOnBrown',
                'style' => 'font-size: 18px; font-weight: bold; text-decoration: none; background: brown; color: white; padding: 0 6px;',
                'title' => 'Белый шрифт на коричневом фоне',
            ]) ?>
        </div>

        <div style="margin-top: 9px;">
            <?= Html::a('А', '', [
                'id'    => 'whiteOnGray',
                'style' => 'font-size: 18px; font-weight: bold; text-decoration: none; background: gray; color: white; padding: 0 6px;',
                'title' => 'Белый шрифт на сером фоне',
            ]) ?>
        </div>

         <div style="margin-top: 9px;">
            <?= Html::a('А', '', [
                'id'    => 'blackOnWhite',
                'style' => 'font-size: 18px; font-weight: bold; text-decoration: none; background: white; color: black; padding: 0 6px; border: 1px solid black',
                'title' => 'Черный шрифт на белом фоне',
            ]) ?>
        </div>

        <div style="margin-top: 9px;">
            <?= Html::a('А', '', [
                'id'    => 'blackOnBrown',
                'style' => 'font-size: 18px; font-weight: bold; text-decoration: none; background: brown; color: black; padding: 0 6px;',
                'title' => 'Черный шрифт на коричневом фоне',
            ]) ?>
        </div>

        <div style="margin-top: 9px;">
            <?= Html::a('А', '', [
                'id'    => 'blackOnGray',
                'style' => 'font-size: 18px; font-weight: bold; text-decoration: none; background: gray; color: black; padding: 0 6px;',
                'title' => 'Черный шрифт на сером фоне',
            ]) ?>
        </div>

</div>