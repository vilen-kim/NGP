<?php

namespace app\models;

use yii\helpers\HtmlPurifier;
use yii\db\ActiveRecord;

class Pages extends \yii\db\ActiveRecord {



    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    
    


    public function afterFind() {
        if (!$this->purified_text && $this->text) {
            $this->purified_text = HTMLPurifier::process($this->text, [
                'Attr.EnableID' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                'AutoFormat.AutoParagraph' => true,
            ]);
            $this->update();
        }
        parent::afterFind();
    }



    public static function tableName() {
        return 'pages';
    }



    public function rules() {
        return [
            [['caption', 'text', 'category_id', 'auth_id'], 'required', 'message' => 'Это обязательное поле'],
            [['text', 'purified_text'], 'string'],
            [['category_id', 'auth_id', 'vk_id'], 'integer'],
            [['caption'], 'string', 'max' => 1024],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['auth_id' => 'id']],
        ];
    }



    public function attributeLabels() {
        return [
            'id' => 'ID',
            'caption' => 'Заголовок',
            'text' => 'Текст',
            'category_id' => 'Категория',
            'created_at' => 'Создание',
            'updated_at' => 'Изменение',
            'fio' => 'Последний редактор',
            'categoryCaption' => 'Категория',
            'vk_id' => 'ID статьи в ВК',
        ];
    }



    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }



    public function getCategoryCaption() {
        return $this->category->caption;
    }



    public function getAuth() {
        return $this->hasOne(Auth::className(), ['id' => 'auth_id']);
    }



    public function getFio() {
        return $this->auth->fio;
    }
}
