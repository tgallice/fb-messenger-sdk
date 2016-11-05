<?php

namespace Tgallice\FBMessenger\Callback;

class RawEvent extends CallbackEvent
{
    const NAME = 'raw_event';

    /**
     * @var array
     */
    private $raw;

    public function __construct($senderId, $recipientId, array $raw)
    {
        parent::__construct($senderId, $recipientId);
        $this->raw = $raw;
    }

    /**
     * @return array
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param string $index
     * @param null|mixed $default
     *
     * @return mixed
     */
    public function get($index, $default = null)
    {
        $indexes = explode('.', trim($index, '.'));
        $payload = $this->raw;
        $value = $default;

        foreach ($indexes as $indexValue) {
            if (!isset($payload[$indexValue])) {
                return $default;
            }
            $value = $payload = $payload[$indexValue];
        }

        return $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
