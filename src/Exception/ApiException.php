<?php

namespace Tgallice\FBMessenger\Exception;

class ApiException extends \RuntimeException
{
    private $errorData;

    /**
     * ApiException constructor.
     *
     * @param string $message
     * @param mixed $errorData
     */
    public function __construct($message, $errorData)
    {
        $this->message = $message;
        $this->errorData = $errorData;

        if (isset($this->errorData['error']['code'])) {
            $this->code = $this->errorData['error']['code'];
        }
    }

    public function getErrorData()
    {
        return $this->errorData;
    }
}
