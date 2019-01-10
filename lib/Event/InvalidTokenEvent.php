<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Event;

use DawBed\ComponentBundle\Event\AbstractEvent;
use DawBed\ConfirmationBundle\Event\Token\ErrorEvent;

class InvalidTokenEvent extends AbstractEvent
{
    private $errorEvent;

    function __construct(ErrorEvent $acceptEvent)
    {
        $this->errorEvent = $acceptEvent;
    }

    public function __call($name, $arguments)
    {
        return $this->errorEvent->{$name}(...$arguments);
    }

    public function getName(): string
    {
        return Events::INVALID_CONFIRMATION_TOKEN;
    }
}