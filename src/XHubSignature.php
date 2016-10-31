<?php

namespace Tgallice\FBMessenger;

class XHubSignature
{
    const ALGORITHM = "sha1";

    /**
     * @param string $payload
     * @param string $secret
     * @param string $signature
     *
     * @return bool
     */
    public static function validate($payload, $secret, $signature)
    {
        return hash_equals(self::compute($payload, $secret), $signature);
    }

    /**
     * @param string $payload
     * @param string $secret
     *
     * @return string
     */
    public static function compute($payload, $secret)
    {
        return hash_hmac(self::ALGORITHM, $payload, $secret);
    }

    /**
     * @param string $header
     *
     * @return string
     */
    public static function parseHeader($header)
    {
        return substr($header, strpos($header, '=')+1);
    }
}
