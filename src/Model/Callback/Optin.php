<?php

namespace Tgallice\FBMessenger\Model\Callback;

class Optin
{
    /**
     * @var string
     */
    private $ref;

    /**
     * @param string $ref
     */
    public function __construct($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        return new static($payload['ref']);
    }
}
