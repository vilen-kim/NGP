<?php
    use yii\helpers\Html;
    use yii\widgets\Breadcrumbs;
    use app\components\MenuWidget;
    app\assets\AppAsset::register($this);
?>



<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php
            $this->beginBody();
            echo $this->render('./header');
            echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 'homeLink' => false]);
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                echo "<div class='alert alert-$key alert-dismissible'>$message</div>";
            }
            echo MenuWidget::widget(['modal' => true]);
        ?>
        
        <div class="container-fluid">
            <?= $content ?>
        </div>
        
        <?php
            echo $this->render('./footer');
            $this->endBody();
        ?>
    </body>
</html>
<?php $this->endPage() ?>