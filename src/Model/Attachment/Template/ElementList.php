<?php

namespace Tgallice\FBMessenger\Model\Attachment\Template;

use Tgallice\FBMessenger\Model\Attachment\Template;
use Tgallice\FBMessenger\Model\Attachment\Template\ElementList\Element;
use Tgallice\FBMessenger\Model\Button as ButtonModel;

class ElementList extends Template
{
    const TOP_STYLE_COMPACT = 'compact';
    const TOP_STYLE_LARGE = 'large';

    /**
     * @var Element[]
     */
    private $elements;

    /**
     * @var ButtonModel|null
     */
    private $button;

    /**
     * @var string
     */
    private $topElementStyle;

    /**
     * @param Element[] $elements
     * @param ButtonModel|null $button
     * @param string $topElementStyle
     */
    public function __construct(array $elements, ?ButtonModel $button = null, $topElementStyle = self::TOP_STYLE_LARGE)
    {
        if (empty($elements) || (count($elements) < 2 || count($elements) > 4)) {
            throw new \InvalidArgumentException('You must provide between 2 and 4 elements.');
        }

        $topElementStyle = strtolower($topElementStyle);

        if (!in_array($topElementStyle, [self::TOP_STYLE_LARGE, self::TOP_STYLE_COMPACT])) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid top element style.', $topElementStyle));
        }

        if ($topElementStyle === self::TOP_STYLE_LARGE && empty($elements[0]->getImageUrl())) {
            throw new \InvalidArgumentException(sprintf('If the top element style is "%s" your first element must have an image url', self::TOP_STYLE_LARGE));
        }

        $this->elements = $elements;
        $this->button = $button;
        $this->topElementStyle = $topElementStyle;
    }

    /**
     * @return Element[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @return string
     */
    public function getTopElementStyle()
    {
        return $this->topElementStyle;
    }

    /**
     * @return null|ButtonModel
     */
    public function getButton()
    {
        return $this->button;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return Template::TYPE_LIST;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'template_type' => $this->getType(),
            'elements' => $this->elements,
            'buttons' => $this->button ? [$this->button] : null,
            'top_element_style' => $this->topElementStyle,
        ];
    }
}
