<?php

namespace ignatenkovnikita\imagemanager\models\generated;

use Yii;

/**
 * This is the model class for table "{{%image_manager}}".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $path
 * @property string $base_url
 * @property string $type
 * @property integer $size
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $tag
 */
class ImageManager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%image_manager}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'path'], 'required'],
            [['owner_id', 'size', 'created_at', 'updated_at'], 'integer'],
            [['path', 'base_url', 'type', 'name', 'tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'owner_id' => Yii::t('app', 'Owner ID'),
            'path' => Yii::t('app', 'Path'),
            'base_url' => Yii::t('app', 'Base Url'),
            'type' => Yii::t('app', 'Type'),
            'size' => Yii::t('app', 'Size'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'tag' => Yii::t('app', 'Tag'),
        ];
    }

    /**
     * @inheritdoc
     * @return ImageManagerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImageManagerQuery(get_called_class());
    }


    public function getFull()
    {
        return $this->base_url . DIRECTORY_SEPARATOR . $this->path;
    }
}
