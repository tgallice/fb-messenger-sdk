<?php

namespace Tgallice\FBMessenger\Attachment;

use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\ExtensionChecker;

class Image extends Attachment
{
    /**
     * @var bool
     */
    private $isRemoteFile;

    /**
     * @var string
     */
    private $path;

    /**
     * @param string $filePath File path of the local/remote file
     */
    public function __construct($filePath)
    {
        $this->path = $filePath;
        $this->type = Attachment::TYPE_IMAGE;

        // Local image is sent with a multipart request
        $this->payload = [];

        if ($this->isRemoteFile()) {
            $this->payload = [
                'url' => $this->path,
            ];
        }

        $this->validateFile();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return resource
     */
    public function open()
    {
        if ($this->isRemoteFile) {
            throw new \RuntimeException('A remote file can not be open');
        }

        return fopen($this->path, 'r');
    }

    /**
     * @return bool
     */
    public function isRemoteFile()
    {
        if (isset($this->isRemoteFile)) {
            return $this->isRemoteFile;
        }

        return $this->isRemoteFile = preg_match('/^(https?|ftp):\/\/.*/', $this->path) === 1;
    }

    private function validateFile()
    {
        if (!ExtensionChecker::check($this->path, ['jpg', 'png'])) {
            throw new \InvalidArgumentException(
                sprintf('"%s" this file has not an allowed extension. Only "png" and "jpg" image are supported', $this->path)
            );
        }

        if (!$this->isRemoteFile() && !is_readable($this->path)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" should be readable', $this->path));
        }
    }
}
