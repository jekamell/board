<?php

class FileBehavior extends CActiveRecordBehavior
{
    public $basePath;

    public function saveImage()
    {
        $this->owner->image->saveAs($this->getImgPath());
    }

    protected function getImgPath()
    {
        return $this->basePath . '/' . $this->getSubDir() . '/' . $this->owner->id . '.' . $this->getExtension();
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
            mkdir($this->basePath . '/' . $sub);
            return $sub;
        } else {
            throw new CException("Can't create folder: $this->basePath/$sub. Permission denied");
        }
    }

    protected function getExtension()
    {
        return $this->owner->image->extensionName;
    }
}
