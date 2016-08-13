<?php

namespace Tgallice\FBMessenger\Exception;

class ApiException extends \RuntimeException
{
    private $apiError;

    /**
     * ApiException constructor.
     *
     * @param string $message
     * @param int $code
     * @param mixed $apiError
     */
    public function __construct($message = '', $code = 0, $apiError = null)
    {
        parent::__construct($message, $code);
        $this->apiError = $apiError;
    }

    /**
     * @return mixed|null
     */
    public function getApiError()
    {
        return $this->apiError;
    }
}
