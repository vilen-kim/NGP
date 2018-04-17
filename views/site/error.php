<?php

use yii\helpers\Html;

$this->title = $name;
?>
<h3 class="page-header text-center"><?= $this->title ?></h3>

<div class="site-error">

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

</div>
