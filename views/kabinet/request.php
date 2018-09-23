<?php
    use yii\helpers\Html;
    app\assets\KabinetAsset::register($this);
    $this->title = 'Личный кабинет';
?>

<h1><?= $this->title ?></h1>

<div class="container">
    <div class="col-md-3">
        <p><?= Html::a('Создать обращение', ['request/write'], ['class' => 'btn btn-default changeBack']) ?></p>
        <p><?= Html::a('Мой профиль', ['auth/view', 'id' => Yii::$app->user->id], ['class' => 'btn btn-default changeBack']) ?></p>
    </div>
    <div class="col-md-9">
        <div class="text-center">
            <?php
                $fromMe = ($countFromMe['inactive']) ? "<span class='badge' title='Неактивные' style='background: orange; color: black; margin-left: 5px;'>{$countFromMe['inactive']}</span>" : '';
                $fromMe .= ($countFromMe['no_answer']) ? "<span class='badge' title='Ожидает ответа' style='background: lightblue; color: black; margin-left: 5px;'>{$countFromMe['no_answer']}</span>" : '';
                $fromMe .= ($countFromMe['answer']) ? "<span class='badge' title='Завершенные' style='background: lightgreen; color: black; margin-left: 5px;'>{$countFromMe['answer']}</span>" : '';
                $toMe = ($countToMe['no_answer']) ? "<span class='badge' title='Ожидает ответа' style='background: lightblue; color: black; margin-left: 5px;'>{$countToMe['no_answer']}</span>" : '';
                $toMe .= ($countToMe['answer']) ? "<span class='badge' title='Завершенные' style='background: lightgreen; color: black; margin-left: 5px;'>{$countToMe['answer']}</span>" : '';
                if ($isExecutive) {
                    echo Html::radioList('requestType', $type, [
                        'fromMe' => "Мои обращения" . $fromMe,
                        'toMe' => "Принятые обращения" . $toMe,
                    ], [
                        'encode' => false,
                        'itemOptions' => ['style' => 'margin-left: 10px;']
                    ]);
                } else {
                    echo "<h4>Мои обращения $fromMe</h4>";
                }
            ?>
        </div>
        <div id="requests">
            <?php
                if (!$detailView){
                    echo 'У Вас пока нет обращений.';
                } else {
                    echo $detailView;
                }
            ?>
        </div>
    </div>
</div>
<div id="forModal"></div>
