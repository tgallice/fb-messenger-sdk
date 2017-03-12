<?php

namespace Tgallice\FBMessenger\Model\Callback;

class Referral
{
    /**
     * @var string
     */
    private $ref;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $type;

    /**
     * @param string $ref
     * @param string $source
     * @param string $type
     */
    public function __construct($ref, $source, $type)
    {
        $this->ref = $ref;
        $this->source = $source;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        return new static($payload['ref'], $payload['source'], $payload['type']);
    }
}
