<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\EventListener;

use DawBed\ComponentBundle\Service\EventDispatcher;
use DawBed\ConfirmationBundle\Event\Token\ErrorEvent;
use DawBed\UserConfirmationBundle\Event\InvalidTokenEvent;

class ErrorListener
{
    private $eventDispatcher;

    function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    function __invoke(ErrorEvent $event) : void
    {
        $this->eventDispatcher->dispatch(new InvalidTokenEvent($event));
    }
}