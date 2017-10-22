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


/**
 * Created by PhpStorm.
 * User: ignatenkovnikita
 * Web Site: http://IgnatenkovNikita.ru
 */
class UploadBehavior extends \trntv\filekit\behaviors\UploadBehavior
{

    public $tag;



    /**
     * @param array $files
     */
    protected function saveFilesToRelation($files)
    {
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

}