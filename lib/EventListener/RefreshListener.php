<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\EventListener;

use DawBed\UserConfirmationBundle\Event\RefreshTokenEvent;
use DawBed\UserConfirmationBundle\Service\Token\RefreshService;

class RefreshListener
{
    private $refreshService;

    function __construct(RefreshService $refreshService)
    {
        $this->refreshService = $refreshService;
    }

    function __invoke(RefreshTokenEvent $event)
    {
        $model = $this->refreshService->prepareModel($event->getCriteria());
        $event->setEntityManager($this->refreshService->make($model));
        $event->setModel($model);
    }
}