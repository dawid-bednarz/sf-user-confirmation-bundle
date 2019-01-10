<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Event;

use DawBed\ComponentBundle\Event\AbstractEvents;

class Events extends AbstractEvents
{
    const GENERATE_USER_TOKEN = 'user_confirmation.generate_token';
    const INVALID_CONFIRMATION_TOKEN = 'user_confirmation.invalid_token';
    const CONFIRMED_ACCOUNT = 'user_confirmation.confirmed_account';
    const REFRESH_CONFIRMATION_TOKEN = 'user_confirmation.refresh_token';

    const ALL = [
        self::GENERATE_USER_TOKEN => self::OPTIONAL,
        self::INVALID_CONFIRMATION_TOKEN => self::REQUIRED,
        self::CONFIRMED_ACCOUNT => self::REQUIRED,
        self::REFRESH_CONFIRMATION_TOKEN => self::OPTIONAL
    ];

    protected function getAll(): array
    {
        return self::ALL;
    }
}