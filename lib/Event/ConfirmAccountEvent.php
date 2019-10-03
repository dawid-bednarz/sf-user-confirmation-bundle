<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Event;

use DawBed\ComponentBundle\Event\AbstractEvent;
use DawBed\ConfirmationBundle\Event\Token\AcceptEvent;
use Dawbed\UserBundle\Entity\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class ConfirmAccountEvent extends AbstractEvent
{
    private $user;
    private $acceptEvent;

    function __construct(UserInterface $user, AcceptEvent $acceptEvent)
    {
        $this->user = $user;
        $this->acceptEvent = $acceptEvent;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setResponse(Response $response): void
    {
        $this->acceptEvent->setResponse($response);
    }

    public function getName(): string
    {
        return Events::CONFIRMED_ACCOUNT;
    }
}