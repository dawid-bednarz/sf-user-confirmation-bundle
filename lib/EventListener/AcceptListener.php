<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\EventListener;

use DawBed\ComponentBundle\Service\EventDispatcher;
use DawBed\ConfirmationBundle\Event\Token\AcceptEvent;
use DawBed\PHPContext\Model\CreateModel;
use DawBed\PHPUserActivateToken\Model\Criteria\ConfirmCriteria;
use DawBed\StatusBundle\Service\CreateService;
use DawBed\UserConfirmationBundle\Entity\Context;
use DawBed\UserConfirmationBundle\Event\ConfirmAccountEvent;
use DawBed\UserConfirmationBundle\Event\InvalidTokenEvent;
use DawBed\UserConfirmationBundle\Service\ConfirmationService;
use DawBed\UserConfirmationBundle\Service\StatusFactoryService;
use Doctrine\ORM\NoResultException;

class AcceptListener
{
    private $confirmationService;
    private $eventDispatcher;
    private $statusFactoryService;
    private $createStatusService;

    function __construct(ConfirmationService $confirmationService,
                         EventDispatcher $eventDispatcher,
                         StatusFactoryService $statusFactoryService,
                         CreateService $createStatusService)
    {
        $this->confirmationService = $confirmationService;
        $this->eventDispatcher = $eventDispatcher;
        $this->statusFactoryService = $statusFactoryService;
        $this->createStatusService = $createStatusService;
    }

    function __invoke(AcceptEvent $event): void
    {
        $token = $event->getToken();

        try {
            $criteria = new ConfirmCriteria();
            $criteria->setToken($token);
            $status = $this->statusFactoryService->build(StatusFactoryService::CONFIRMATED_ID);
            $criteria->setStatus($status->getEntity());

            $model = $this->confirmationService->prepareModel($criteria);

            $em = $this->confirmationService->make($model);

            $this->eventDispatcher->dispatch(new ConfirmAccountEvent($model->getEntity()->getUser(), $event));

            $em->flush();

        } catch (NoResultException $exception) {

            $this->eventDispatcher->dispatch(new InvalidTokenEvent($event));
        }

    }
}