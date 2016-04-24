<?php

namespace Tgallice\FBMessenger\Exception;

class ApiException extends \RuntimeException
{
    /**
     * @var array
     */
    private $errorData;

    public function __construct($message, array $errorData = [])
    {
        $this->message = $message;
        $this->errorData = $errorData;

        if (isset($errorData['code'])) {
            $this->code = $errorData['code'];
        }
    }

    public function getErrorData()
    {
        return $this->errorData;
    }
}
