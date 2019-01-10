<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Event;

class RefreshTokenEvent extends GenerateTokenEvent
{
    public function getName(): string
    {
        return Events::REFRESH_CONFIRMATION_TOKEN;
    }
}