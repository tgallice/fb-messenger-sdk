<?php

namespace Tgallice\FBMessenger\Attachment;

use Tgallice\FBMessenger\Attachment;
use Tgallice\FBMessenger\ExtensionChecker;

class ImageUrl extends Attachment
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        if (!ExtensionChecker::check($url, ['jpg', 'png'])) {
            throw new \InvalidArgumentException(
                sprintf('"%s" this file has not a allowed extension. Only "png" and "jpg" image are supported', $url)
            );
        }

        if (preg_match('/^(https?|ftp):\/\/.*/', $url) !== 1) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid remote file', $url));
        }

        $this->url = $url;
        $this->payload = [
            'url' => $this->url,
        ];
        $this->type = Attachment::TYPE_IMAGE;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
