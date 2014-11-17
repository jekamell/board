<?php

/**
 * Class FileBehavior
 *
 * Relations: 'ext.CImageHandler.CImageHandler.php'
 */
class FileBehavior extends CActiveRecordBehavior
{
    const EXTENSION_JPG = 'jpeg';
    const EXTENSION_PNG = 'png';
    const PREFIX_THUMB = '_thumb';

    public $basePath;

    public function saveImage()
    {
        return $this->owner->image->saveAs($this->getAbsolutePath());
    }

    public function makeThumb()
    {
        if (!Yii::app()->hasComponent('ih')) {
             throw new CException('No image handler extension found. Please install it and try again');
        }

        return Yii::app()->ih
            ->load($this->getAbsolutePath())
            ->thumb(Yii::app()->params['image']['thumb']['width'], Yii::app()->params['image']['thumb']['height'])
            ->save($this->getAbsolutePath(self::PREFIX_THUMB));
    }

    public function getHttpPath($filePrefix = '')
    {
        if (!is_file($this->getAbsolutePath($filePrefix))) {
            return ''; // TODO: return default picture here
        }

        return str_replace(Yii::getPathOfAlias('webroot'), '', $this->getAbsolutePath($filePrefix));
    }

    protected function getAbsolutePath($filePrefix = '')
    {
        return $this->basePath .  $this->getSubDir() . '/' . $this->owner->id . $filePrefix . '.' . $this->getExtension();
    }

    /**
     * Allow find files on file system faster then if they located just in one directory
     *
     * @return string subdirectory name (like 25, 01, 99, etc)
     * @throws CException
     */
    protected function getSubDir()
    {
        $sub = strlen($this->owner->id) >= 2 ? substr($this->owner->id, -2) : '0' . $this->owner->id;

        if (is_dir($this->basePath . $sub)) {
            return $sub;
        } elseif (is_writable($this->basePath)) {
            mkdir($this->basePath . '/' . $sub, 0777, true);
            return $sub;
        } else {
            throw new CException("Can't create folder: $this->basePath/$sub. Permission denied");
        }
    }

    protected function getExtension()
    {
        // save file case
        if ($this->owner->image) {
            return $this->owner->image->extensionName;
        }
        // get file case
        elseif (is_file($this->basePath . $this->getSubDir() . '/' . $this->owner->id . '.' . self::EXTENSION_JPG)) {
            return self::EXTENSION_JPG;
        } elseif (is_file($this->basePath . $this->getSubDir() . '/' . $this->owner->id . '.' . self::EXTENSION_PNG)) {
            return self::EXTENSION_PNG;
        }
    }
}
