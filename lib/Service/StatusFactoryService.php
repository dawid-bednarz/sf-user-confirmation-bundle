<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Service;

use DawBed\ContextBundle\Service\AbstractContextFactory;
use DawBed\ContextBundle\Service\CreateServiceInterface;
use DawBed\ContextBundle\Service\FactoryCollection;
use DawBed\PHPClassProvider\ClassProvider;
use DawBed\StatusBundle\Entity\AbstractStatus;
use DawBed\StatusBundle\Service\CreateService;

class StatusFactoryService extends AbstractContextFactory
{
    const CONFIRMATED_ID = 2;

    private $entityService;
    private $createService;

    public function __construct(CreateService $createService)
    {
        $this->entityService = $entityService;
    }

    protected function getCreateService(): CreateServiceInterface
    {
        return $this->createService;
    }

    protected function getFactories(): FactoryCollection
    {
        $factoryCollection = new FactoryCollection();
        $factoryCollection->append(self::CONFIRMATED_ID, $this->confirmated());
        return $factoryCollection;
    }

    private function confirmated(): \Closure
    {
        return \Closure::bind(function (): AbstractStatus {
            return (ClassProvider::new(AbstractStatus::class))
                ->setType(self::CONFIRMATED_ID)
                ->setName('Confirmated');
        }, $this);
    }
}