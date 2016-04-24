<?php

namespace Tgallice\FBMessenger\Attachment;

use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\ExtensionChecker;

class Image extends Attachment
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path Path of the local image to send
     */
    public function __construct($path)
    {
        if (!ExtensionChecker::check($path, ['jpg', 'png'])) {
            throw new \InvalidArgumentException(
                sprintf('"%s" this file has not a allowed extension. Only "png" and "jpg" image are supported', $path)
            );
        }

        if (!is_readable($path)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" should be readable', $path));
        }

        $this->path = $path;
        // Image payload is empty.
        // The image is sent with a multipart request
        $this->payload = [];
        $this->type = Attachment::TYPE_IMAGE;
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
        return fopen($this->path, 'r');
    }
}
