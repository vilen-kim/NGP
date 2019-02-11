<?php
    use yii\bootstrap\Modal;
    use yii\helpers\Html;

    $special_version = Yii::$app->request->cookies->getValue('special_version');
    $style = ($special_version) ? 'font-size: 20px; padding: 15px;' : '';
    Modal::begin([
        'id' => 'modalPhone',
        'header' => "<h2 class='caption'>Справочник телефонов</h2>",
        'size' => Modal::SIZE_DEFAULT,
        'clientOptions' => [
            'show' => false,
        ],
    ]);
?>


<?= Html::beginTag('div', ['style' => $style]) ?>
    <p>Получить необходимую информацию у специалистов БУ "Няганская городская поликлиника можно,
        позвонив на единый номер <b>5-45-30</b>, а затем набрать внутренний номер абонента:</p>
    <div style="margin-width: 20px">
        <p><b>5-45-30 доб. 204</b> - Приемная</p>
        <p><b>5-45-30 доб. 101</b> - Вызов врача на дом</p>
        <p><b>5-45-30 доб. 102, 5-45-19</b> - Колл-центр, Запись на прием</p>
    </div>
    <p>
        <?= Html::a('Показать все телефоны', ['site/show', 'id' => 52]) ?>
    </p>
<?= Html::endTag('div') ?>

<?php Modal::end();
