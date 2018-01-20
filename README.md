Yii2 Image Manager
==================
Yii2 Image Manager

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist ignatenkovnikita/yii2-imagemanager "*"
```

or add

```
"ignatenkovnikita/yii2-imagemanager": "*"
```

to the require section of your `composer.json` file.


Usage
-----
Example use on product preview and attachments

Add in model Product
```php
public $attachments;
public $attachment;

const NAME_ATTACHMENTS = 'product.attachments';
const NAME_ATTACHMENT = 'product.attachment';
    
public function rules()
{
    return ArrayHelper::merge(parent::rules(), [
        [['attachments', 'attachment'], 'safe'],
    ]);
}    


public function behaviors()
{
    return ArrayHelper::merge(parent::behaviors(), [
        [
            'class' => \ignatenkovnikita\imagemanager\behaviors\UploadBehavior::className(),
            'attribute' => 'attachments',
            'multiple' => true,
            'tag' => self::NAME_ATTACHMENTS,
            'pathAttribute' => 'path',
            'uploadRelation' => 'productAttachments',
            'baseUrlAttribute' => 'base_url',
            'orderAttribute' => 'order',
            'typeAttribute' => 'type',
            'sizeAttribute' => 'size',
            'nameAttribute' => 'name',
        ],
        [
            'class' => \ignatenkovnikita\imagemanager\behaviors\UploadBehavior::className(),
            'attribute' => 'attachment',
            'multiple' => false,
            'tag' => self::NAME_ATTACHMENT,
            'uploadRelation' => 'productAttachment',
            'pathAttribute' => 'path',
            'baseUrlAttribute' => 'base_url',
            'orderAttribute' => 'order',
            'typeAttribute' => 'type',
            'sizeAttribute' => 'size',
            'nameAttribute' => 'name',
        ],
    ]);
}


/**
 * @return \yii\db\ActiveQuery
 * @throws \Exception
 */
public function getProductAttachments()
{
    return $this->hasMany(ImageManager::class, ['owner_id' => 'id'])->andWhere(['tag' => self::NAME_ATTACHMENTS]);
}

/**
 * @return \yii\db\ActiveQuery
 * @throws \Exception
 */
public function getProductAttachment()
{
    return $this->hasOne(ImageManager::class, ['owner_id' => 'id'])->andWhere(['tag' => self::NAME_ATTACHMENT]);
}

```


Add widget on view
```html

<?php echo $form->field($model, 'attachment')->widget(
    Upload::className(),
    [
        'url' => ['/file-storage/upload'],
        'maxFileSize' => 5000000, // 5 MiB
    ]);
?>

<?php echo $form->field($model, 'attachments')->widget(
    Upload::className(),
    [
        'url' => ['/file-storage/upload'],
        'sortable' => true,
        'maxFileSize' => 10000000, // 10 MiB
        'maxNumberOfFiles' => 10
    ]);
?>
```
