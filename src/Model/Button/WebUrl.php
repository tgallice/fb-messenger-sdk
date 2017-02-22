<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class WebUrl extends Button
{
    const HEIGHT_RATIO_FULL = 'full';
    const HEIGHT_RATIO_COMPACT = 'compact';
    const HEIGHT_RATIO_TALL = 'tall';

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $webviewHeightRatio = self::HEIGHT_RATIO_FULL;

    /**
     * @var bool
     */
    private $messengerExtensions = false;

    /**
     * @var string|null
     */
    public $fallbackUrl;

    /**
     * @param string $title
     * @param string $url
     */
    public function __construct($title, $url)
    {
        parent::__construct(Button::TYPE_WEB_URL);

        self::validateTitleSize($title);
        $this->title = $title;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $ratio
     */
    public function setWebviewHeightRatio($ratio)
    {
        if (!in_array($ratio, $this->getAllowedHeights())) {
            throw new \InvalidArgumentException(sprintf('Webview height ratio must be one of this values: [%s]', implode(', ', $this->getAllowedHeights())));
        }

        $this->webviewHeightRatio = $ratio;
    }

    /**
     * @param bool $messengerExtensions
     */
    public function setMessengerExtensions($messengerExtensions)
    {
        $this->messengerExtensions = $messengerExtensions;
    }

    /**
     * @param string $fallbackUrl
     */
    public function setFallbackUrl($fallbackUrl)
    {
        $this->fallbackUrl = $fallbackUrl;
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
        $json = parent::jsonSerialize();

        $json['title'] = $this->title;
        $json['url'] = $this->url;

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

    /**
     * @return string[]
     */
    private function getAllowedHeights()
    {
        return [
            self::HEIGHT_RATIO_FULL,
            self::HEIGHT_RATIO_COMPACT,
            self::HEIGHT_RATIO_TALL
        ];
    }
}
