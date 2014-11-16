<?php

class FileBehavior extends CActiveRecordBehavior
{
    const EXTENSION_JPG = 'jpeg';
    const EXTENSING_PNG = 'png';
    public $basePath;

    public function saveImage()
    {
        $this->owner->image->saveAs($this->getAbsolutePath());
    }

    protected function getAbsolutePath()
    {
        return $this->basePath .  $this->getSubDir() . '/' . $this->owner->id . '.' . $this->getExtension();
    }

    public function getHttpPath()
    {
        return str_replace(Yii::getPathOfAlias('webroot'), '', $this->getAbsolutePath());
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
//        exit($this->basePath . $this->getSubDir() . $this->owner->id . '.' . self::EXTENSION_JPG);
        // get file case
        elseif (is_file($this->basePath . $this->getSubDir() . '/' . $this->owner->id . '.' . self::EXTENSION_JPG)) {
            return self::EXTENSION_JPG;
        } elseif (is_file($this->basePath . $this->getSubDir() . '/' . $this->owner->id . '.' . self::EXTENSING_PNG)) {
            return self::EXTENSING_PNG;
        }
    }
}
