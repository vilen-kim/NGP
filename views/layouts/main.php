<?php
    use yii\helpers\Html;
    use yii\widgets\Breadcrumbs;
    $special_version = Yii::$app->request->cookies->getValue('special_version');
    if (Yii::$app->mobileDetect->isMobile()) {
        app\assets\MobileAppAsset::register($this);
    } else if ($special_version){
        app\assets\SpecialAppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

?>

<?php $this->beginPage() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 
        <link rel="icon" type="image/png" href="/icon96.png" sizes="96x96">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <div><img src="https://mc.yandex.ru/watch/50670112" style="position:absolute; left:-9999px;" alt="" /></div>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div id="bottomHolder">
            <div style="position: absolute; top: 110px; left: 0; width: 100%;" class="container">
                <?php
                    
                    if (!Yii::$app->mobileDetect->isMobile()){
                        echo Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]);
                    }
                    
                    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                        echo Html::beginTag('div', ['class' => "alert alert-$key alert-dismissible"]);
                            echo $message;
                            $close = Html::tag('span', '', [
                                'class' => 'glyphicon glyphicon-remove pull-right flash-close',
                            ]);
                            echo Html::a($close, '');
                        echo html::endTag('div');
                    };

                ?>
            </div>
            <?php
                if ($special_version == 1) {
                    echo Html::tag('div', $content, ['id' => 'content']);
                } else {
                    echo $content;
                }
            ?>
            <div id="footerHolder">
                <?= $this->render('./footer') ?>
            </div>
        </div>
        <div id="headerHolder">
            <?= $this->render('./header') ?>
        </div>
        <div id="forModal"></div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage();