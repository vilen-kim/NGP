<?php
    use yii\helpers\Html;
    use yii\widgets\Breadcrumbs;
    app\assets\AppAsset::register($this);
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
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div id="bottomHolder">
            <div style="position: absolute; top: 83px; left: 0; width: 100%;" class="container">
                <?php
                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]);
                    
                    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                        echo Html::beginTag('div', ['class' => "alert alert-$key alert-dismissible"]);
                            echo $message;
                            $close = Html::tag('span', '', [
                                'class' => 'glyphicon glyphicon-remove pull-right flash-close',
                            ]);
                            echo Html::a($close, '');
                        echo html::endTag('div');
                    };

                    if (Yii::$app->session->get('eye')){
                        echo $this->render('./eyePanel');
                    }
                ?>
            </div>
            <?= $content ?>
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