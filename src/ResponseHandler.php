<?php

namespace Tgallice\FBMessenger;

use Psr\Http\Message\ResponseInterface;

trait ResponseHandler
{
    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    public function decodeResponse(ResponseInterface $response)
    {
        return json_decode((string) $response->getBody(), true);
    }
}
