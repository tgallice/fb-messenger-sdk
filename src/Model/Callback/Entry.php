<?php

namespace Tgallice\FBMessenger\Model\Callback;

use Tgallice\FBMessenger\Callback\CallbackEvent;
use Tgallice\FBMessenger\CallbackEventFactory;

class Entry
{
    /**
     * @var string
     */
    private $pageId;
    /**
     * @var int
     */
    private $time;

    /**
     * @var CallbackEvent[]
     */
    private $events;

    /**
     * @param string $pageId
     * @param int $time
     * @param CallbackEvent[] $events
     */
    public function __construct($pageId, $time, array $events)
    {
        $this->pageId = $pageId;
        $this->time = $time;
        $this->events = $events;
    }

    /**
     * @return string
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return CallbackEvent[]
     */
    public function getCallbackEvents()
    {
        return $this->events;
    }

    /**
     * @param array $raw
     *
     * @return static
     */
    public static function create(array $raw)
    {
        $events = [];

        foreach ($raw['messaging'] as $rawEvent) {
            $events[] = CallbackEventFactory::create($rawEvent);
        }

        return new static($raw['id'], $raw['time'], $events);
    }
}
