<?php

namespace Tgallice\FBMessenger\Model\Callback;

class AccountLinking
{
    const STATUS_LINKED = 'linked';
    const STATUS_UNLINKED = 'unlinked';
    /**
     * @var string
     */
    private $status;

    /**
     * @var null|string
     */
    private $authorizationCode;

    /**
     * @param string $status
     * @param null|string $authorizationCode
     */
    public function __construct($status, $authorizationCode = null)
    {
        $this->status = $status;
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return null|string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param array $payload
     *
     * @return static
     */
    public static function create(array $payload)
    {
        $authorizationCode = isset($payload['authorization_code']) ? $payload['authorization_code'] : null;
        return new static($payload['status'], $authorizationCode);
    }
}
