<?php

namespace app\components;

use Yii;
use iutbay\yii2kcfinder\KCFinderAsset;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditorWidgetAsset;
use yii\helpers\Json;

class Editor extends CKEditor {

    public $enableKCFinder = true;
    public $path = '/files';



    protected function registerPlugin() {
        if ($this->enableKCFinder) {
            $this->registerKCFinder();
        }
        $js = [];
        $view = $this->getView();
        CKEditorWidgetAsset::register($view);
        $id = $this->options['id'];
        $options = $this->clientOptions !== false && !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '{}';
        $js[] = "CKEDITOR.replace('$id', $options);";
        $js[] = "dosamigos.ckEditorWidget.registerOnChangeHandler('$id');";
        if (isset($this->clientOptions['filebrowserUploadUrl']) || isset($this->clientOptions['filebrowserImageUploadUrl'])) {
            $js[] = "dosamigos.ckEditorWidget.registerCsrfImageUploadHandler();";
        }
        $view->registerJs(implode("\n", $js));
    }



    protected function registerKCFinder() {
        $_SESSION['KCFINDER'] = [
            'disabled' => false,
            'uploadURL' => $this->path,
            'uploadDir' => Yii::getAlias('@web'),
        ];
        
        $register = KCFinderAsset::register($this->view);
        $kcfinderUrl = $register->baseUrl;

        $browseOptions = [
            'filebrowserBrowseUrl' => $kcfinderUrl . '/browse.php?opener=ckeditor&type=files',
            'filebrowserUploadUrl' => $kcfinderUrl . '/upload.php?opener=ckeditor&type=files',
            'filebrowserImageBrowseUrl' => $kcfinderUrl . '/browse.php?opener=ckeditor&type=images',
            'filebrowserImageUploadUrl' => $kcfinderUrl . '/upload.php?opener=ckeditor&type=images',
        ];

        $this->clientOptions = ArrayHelper::merge($browseOptions, $this->clientOptions);
    }
}
