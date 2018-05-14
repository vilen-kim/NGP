<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "errors".
 *
 * @property int $id
 * @property string $controller
 * @property string $action
 * @property string $doing
 * @property string $error
 * @property int $auth_id
 */
class Errors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'errors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller', 'action', 'doing', 'error', 'auth_id'], 'required'],
            [['error'], 'string'],
            [['auth_id'], 'integer'],
            [['controller', 'action'], 'string', 'max' => 255],
            [['doing'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller' => 'Controller',
            'action' => 'Action',
            'doing' => 'Doing',
            'error' => 'Error',
            'auth_id' => 'Auth ID',
        ];
    }
}
