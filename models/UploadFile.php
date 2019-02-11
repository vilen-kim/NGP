<?php

namespace app\models;

use yii\base\Model;

class UploadFile extends Model
{

    public $file;
    public $caption;
    public $number;
    public $date;
    public $isArchive;
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DEFAULT = 'default';


    public function rules()
    {
        return [
            [
                'file',
                'file',
                'skipOnEmpty' => false,
//                'extensions' => 'pdf, doc, docx',
                'on' => $this::SCENARIO_DEFAULT
            ],
            ['file', 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, doc, docx', 'on' => $this::SCENARIO_UPDATE],
            [['caption', 'date', 'number'], 'required', 'message' => 'Это обязательное поле'],
            ['caption', 'string', 'max' => 8192],
            ['number', 'string', 'max' => 255],
            ['date', 'date'],
            ['isArchive', 'boolean', 'on' => $this::SCENARIO_UPDATE],
        ];
    }


    public function upload()
    {
        if ($this->validate() && isset($this->file)) {
            $filename = 'orders/' . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs($filename);
            return $filename;
        } else {
            return false;
        }
    }


    public function attributeLabels()
    {
        return [
            'file' => 'Файл',
            'caption' => 'Наименование',
            'number' => 'Номер',
            'date' => 'Дата',
        ];
    }
}