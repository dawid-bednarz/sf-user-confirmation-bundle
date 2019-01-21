<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Service;

use DawBed\ComponentBundle\Service\EventDispatcher;
use DawBed\ConfirmationBundle\Event\Events;
use DawBed\ConfirmationBundle\Event\Token\GenerateEvent as GenerateTokenEvent;
use DawBed\ConfirmationBundle\Event\Token\RefreshEvent as RefreshTokenEvent;
use DawBed\PHPToken\DTO\TokenSetting;
use DawBed\PHPToken\TokenInterface;
use DawBed\PHPUserActivateToken\Model\Criteria\CreateCriteria;

class TokenService
{
    public const TYPE = CreateCriteria::TYPE_TOKEN;
    public const ACCEPT_EVENT = Events::ACCEPT_TOKEN . self::TYPE;
    public const ERROR_EVENT = Events::ERROR_ACCEPT_TOKEN . self::TYPE;

    private $eventDispatcher;

    function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function generate(TokenSetting $setting): TokenInterface
    {
        $generateEvent = new GenerateTokenEvent($setting);

        return $this->eventDispatcher->dispatch($generateEvent)
            ->getToken();
    }

    public function refresh(TokenInterface $token, TokenSetting $setting): TokenInterface
    {
        $refreshEvent = new RefreshTokenEvent($token, $setting);

        return $this->eventDispatcher->dispatch($refreshEvent)
            ->getToken();
    }
}