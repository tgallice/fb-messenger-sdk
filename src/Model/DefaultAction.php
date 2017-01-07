<?php

namespace Tgallice\FBMessenger\Model;

class DefaultAction implements \JsonSerializable
{
    const HEIGHT_RATIO_FULL = 'full';
    const HEIGHT_RATIO_COMPACT = 'compact';
    const HEIGHT_RATIO_TALL = 'tall';

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $webviewHeightRatio;

    /**
     * @var bool
     */
    private $messengerExtensions = false;

    /**
     * @var string|null
     */
    public $fallbackUrl;

    /**
     * @param string $url
     * @param string $webviewHeghtRatio
     * @param bool $messengerExtensions
     * @param null|string $fallbaclUrl
     */
    public function __construct($url, $webviewHeghtRatio = self::HEIGHT_RATIO_FULL, $messengerExtensions = false, $fallbaclUrl = null)
    {
        $this->url = $url;
        $this->webviewHeightRatio = $webviewHeghtRatio;
        $this->messengerExtensions = (bool) $messengerExtensions;
        $this->fallbackUrl = $fallbaclUrl;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getWebviewHeightRatio()
    {
        return $this->webviewHeightRatio;
    }

    /**
     * @return string|null
     */
    public function getFallbackUrl()
    {
        return $this->fallbackUrl;
    }

    /**
     * @return bool
     */
    public function useMessengerExtensions()
    {
        return $this->messengerExtensions;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $json = [
            'type' => 'web_url',
            'url' => $this->url,
        ];

        if (!empty($this->webviewHeightRatio)) {
            $json['webview_height_ratio'] = $this->webviewHeightRatio;
        }

        if ($this->messengerExtensions) {
            $json['messenger_extensions'] = $this->messengerExtensions;
        }

        if ($this->messengerExtensions && !empty($this->fallbackUrl)) {
            $json['fallback_url'] = $this->fallbackUrl;
        }

        return $json;
    }
}
