<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Event;

use DawBed\ComponentBundle\Event\AbstractEvent;
use DawBed\PHPUserActivateToken\Model\Criteria\CreateCriteria;
use Doctrine\ORM\EntityManagerInterface;

class GenerateTokenEvent extends AbstractEvent
{
    private $criteria;
    private $model;
    private $entityManager;

    function __construct(CreateCriteria $criteria)
    {
        $this->criteria = $criteria;
    }

    public function getCriteria(): CreateCriteria
    {
        return $this->criteria;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    public function getName(): string
    {
        return Events::GENERATE_USER_TOKEN;
    }
}