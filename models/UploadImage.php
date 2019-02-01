<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadImage extends Model{

	public $image;
	public $url;
    public $main;
    public $tag;
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DEFAULT = 'default';



	public function rules(){
		return[
			['image', 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'on' => $this::SCENARIO_DEFAULT],
            ['image', 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'on' => $this::SCENARIO_UPDATE],
			['url', 'url'],
            ['url', 'required', 'message' => 'Это обязательное поле'],
            ['main', 'boolean'],
            ['main', 'default', 'value' => false],
            ['tag', 'string', 'max' => 255],
		];
	}



	public function upload()
    {
        if ($this->validate() && isset($this->image)) {
            $filename = 'images/banners/' . uniqid() . '.' . $this->image->extension;
            $this->image->saveAs($filename);
            return $filename;
        } else {
            return false;
        }
    }


        
	public function attributeLabels() {
        return [
            'image' => 'Изображение',
            'url' => 'Ссылка',
            'main' => 'Отображать на главной',
            'tag' => 'Альтернативный текст',
        ];
    }
}