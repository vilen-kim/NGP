<?php
    use yii\helpers\Html;
    app\assets\AppAsset::register($this);
?>



<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <div id="backImage">
        <div id="backImageOver">
            
            <?php $this->beginBody() ?>
            
            <div class="container-fluid" id="headerHolder">
                <?= $this->render('./header') ?>
            </div>
            <div class="container" style="margin-top: 50px; margin-bottom: 50px">
                <?= $content ?>
            </div>
            <div class="container-fluid" id="footerHolder">
                <?= $this->render('./footer') ?>
            </div>
            
            <?php $this->endBody() ?>
            
        </div>
        </div>
            
    </body>
</html>
<?php $this->endPage();