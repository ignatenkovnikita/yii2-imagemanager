<?php

namespace ignatenkovnikita\imagemanager\models\generated;

/**
 * This is the ActiveQuery class for [[ImageManager]].
 *
 * @see ImageManager
 */
class ImageManagerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ImageManager[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ImageManager|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
