<?php

namespace Tgallice\FBMessenger;

class ExtensionChecker
{
    /**
     * @param string $filename
     * @param array $allowedExtension
     *
     * @return bool
     */
    public static function check($filename, array $allowedExtension)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (empty($ext)) {
            return false;
        }

        return in_array($ext, $allowedExtension);
    }
}
