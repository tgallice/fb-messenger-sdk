<?php

namespace Tgallice\FBMessenger\Model\Attachment;

use Tgallice\FBMessenger\ExtensionChecker;
use Tgallice\FBMessenger\Model\Attachment;

class File extends Attachment
{
    /**
     * @var string|null
     */
    private $path;

    /**
     * @var bool
     */
    private $isRemoteFile;

    /**
     * @var null|resource
     */
    private $stream;

    /**
     * @var array
     */
    protected $allowedExtensions = [];

    /**
     * @param string $type
     * @param string $filePath
     */
    public function __construct($filePath, $type = Attachment::TYPE_FILE)
    {
        $this->path = $filePath;

        // Local image is sent with a multipart request
        $payload = [];

        if ($this->isRemoteFile()) {
            $payload = [
                'url' => $this->path,
            ];
        }

        $this->validateExtension();

        parent::__construct($type, $payload);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function open()
    {
        if ($this->stream) {
            return;
        }

        if ($this->isRemoteFile()) {
            throw new \RuntimeException('A remote file can not be open');
        }
        
        if (!is_readable($this->path)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" should be readable', $this->path));
        }

        $this->stream = fopen($this->path, 'r');

        if (!$this->stream) {
            throw new \InvalidArgumentException(sprintf('Unable to open the media "%s"', $this->path));
        }
    }

    /**
     * @return null|resource
     */
    public function getStream()
    {
        $this->open();

        return $this->stream;
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

    private function validateExtension()
    {
        if (!empty($this->allowedExtensions) && !ExtensionChecker::check($this->path, $this->allowedExtensions)) {
            throw new \InvalidArgumentException(
                sprintf('"%s" this file has not an allowed extension. Only %s extensions are supported', $this->path, '["'. implode('", "', $this->allowedExtensions) .'"]')
            );
        }
    }
}
