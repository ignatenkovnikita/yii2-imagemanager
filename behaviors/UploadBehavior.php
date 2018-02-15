<?php

namespace ignatenkovnikita\imagemanager\behaviors;

/**
 * Copyright (C) $user$, Inc - All Rights Reserved
 *
 *  <other text>
 * @file        UploadBehavior.php
 * @author      ignatenkovnikita
 * @date        $date$
 */

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


/**
 * Created by PhpStorm.
 * User: ignatenkovnikita
 * Web Site: http://IgnatenkovNikita.ru
 */
class UploadBehavior extends \trntv\filekit\behaviors\UploadBehavior
{

    public $tag;


    public function events()
    {
        $multipleEvents = [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFindMultiple',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsertMultiple',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateMultiple',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDeleteMultiple',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];

        $singleEvents = [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFindSingle',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsertSingle',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdateSingle',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDeleteSingle',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];

        return $this->multiple ? $multipleEvents : $singleEvents;
    }


    /**
     * @param array $files
     */
    protected function saveFilesToRelation($files)
    {
        if(is_array($files)){
            if(isset($files['path'])){
                $files = [$files];
            }
        }
        $modelClass = $this->getUploadModelClass();
        foreach ($files as $file) {
            $model = new $modelClass;
            $model->setScenario($this->uploadModelScenario);
            $model = $this->loadModel($model, $file);
            $model->tag = $this->tag;
            if ($this->getUploadRelation()->via !== null) {
                $model->save(false);
            }
            $this->owner->link($this->uploadRelation, $model);
        }
    }


    public function afterFindSingle()
    {
        $model = $this->owner->{$this->uploadRelation};
        $fields = $this->fields();
        $data = null;
        if ($model) {
            /* @var $model \yii\db\BaseActiveRecord */
            $file = [];
            foreach ($fields as $dataField => $modelAttribute) {
                $file[$dataField] = $model->hasAttribute($modelAttribute)
                    ? ArrayHelper::getValue($model, $modelAttribute)
                    : null;
            }

            if ($file['path']) {
                $data = $this->enrichFileData($file);
            }
        }


        $this->owner->{$this->attribute} = $data;
    }

    public function afterInsertSingle()
    {
        if ($this->owner->{$this->attribute}) {
            $this->saveFilesToRelation($this->owner->{$this->attribute});
        }
    }

    public function afterUpdateSingle()
    {
        $file = $this->getUploaded();
        $filePath = null;
        if ($file && isset($file['path'])) {
            $filePath = $file['path'];
        }
        $model = $this->owner->getRelation($this->uploadRelation)->one();
        $modelPath = null;
        if ($model) {
            $modelPath = $model->path;
        }
        $newFiles = $updatedFiles = [];
        if ($model) {
            $path = $model->getAttribute($this->getAttributeField('path'));
            if ($path != $filePath && $model->delete()) {
                $this->getStorage()->delete($path);
            }
        }
        if ($file) {
            if ($file['path'] != $modelPath) {
                $newFiles[] = $file;
            } else {
                $updatedFiles[] = $file;
            }
        }
        $this->saveFilesToRelation($newFiles);
        $this->updateFilesInRelation($updatedFiles);
    }


    public function beforeDeleteSingle()
    {
        $this->deletePaths = ArrayHelper::getColumn($this->getUploaded(), 'path');
    }

}