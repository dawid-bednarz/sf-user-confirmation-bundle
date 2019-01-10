<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\EventListener;

use DawBed\UserConfirmationBundle\Event\GenerateTokenEvent;
use DawBed\UserConfirmationBundle\Service\Token\CreateService;

class GenerateListener
{
    private $createService;

    function __construct(CreateService $createService)
    {
        $this->createService = $createService;
    }

    function __invoke(GenerateTokenEvent $event): void
    {
        $model = $this->createService->prepareModel($event->getCriteria());
        $entityManager = $this->createService->make($model);
        $event->setModel($model);
        $event->setEntityManager($entityManager);
    }
}