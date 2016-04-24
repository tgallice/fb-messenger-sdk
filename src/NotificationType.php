<?php

namespace Tgallice\FBMessenger;

interface NotificationType
{
    /**
     * Emit sound/vibration and a phone notification
     */
    const REGULAR = 'REGULAR';

    /**
     * Emit a phone notification
     */
    const SILENT = 'SILENT_PUSH';

    /**
     * Not emit
     */
    const NO_PUSH = 'NO_PUSH';
}
