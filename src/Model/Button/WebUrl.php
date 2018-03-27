<?php

namespace Tgallice\FBMessenger\Model\Button;

use Tgallice\FBMessenger\Model\Button;

class WebUrl extends Button
{
    const HEIGHT_RATIO_FULL = 'full';
    const HEIGHT_RATIO_COMPACT = 'compact';
    const HEIGHT_RATIO_TALL = 'tall';

    const WEBVIEW_SHARE_BUTTON_SHOW = 'show';
    const WEBVIEW_SHARE_BUTTON_HIDE = 'hide';

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
     * @var string
     */
    private $webviewShareButton = self::WEBVIEW_SHARE_BUTTON_SHOW;

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
     * @param $value
     */
    public function setWebviewShareButton($value)
    {
        if (!in_array($value, $this->getAllowedWebviewShareButton())) {
          throw new \InvalidArgumentException(sprintf('Webview share button must be one of this values: [%s]', implode(', ', $this->getAllowedWebviewShareButton())));
        }

        $this->webviewShareButton = $value;
    }

    /**
     * @return string|null
     */
    public function getWebviewShareButton()
    {
      return $this->webviewShareButton;
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

        if (!empty($this->webviewShareButton)) {
            $json['webview_share_button'] = $this->webviewShareButton;
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

    /**
     * @return string[]
     */
    private function getAllowedWebviewShareButton()
    {
      return [
        self::WEBVIEW_SHARE_BUTTON_SHOW,
        self::WEBVIEW_SHARE_BUTTON_HIDE
      ];
    }
}
