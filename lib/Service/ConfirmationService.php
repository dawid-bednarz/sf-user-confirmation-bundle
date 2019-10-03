<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Service;

use DawBed\PHPClassProvider\ClassProvider;
use DawBed\PHPUserActivateToken\Model\ConfirmModel;
use DawBed\PHPUserActivateToken\Model\Criteria\ConfirmCriteria;
use DawBed\UserBundle\Entity\AbstractUserStatus;
use DawBed\UserConfirmationBundle\Repository\UserActiveTokenRepository;
use Doctrine\ORM\EntityManagerInterface;

class ConfirmationService
{
    private $entityManager;
    private $repository;

    function __construct(UserActiveTokenRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    public function prepareModel(ConfirmCriteria $criteria): ConfirmModel
    {
        $userActivateToken = $this->repository->findToConfirm($criteria->getToken());

        return new ConfirmModel($userActivateToken, ClassProvider::new(AbstractUserStatus::class), $criteria->getStatus());
    }

    public function make(ConfirmModel $confirmModel): EntityManagerInterface
    {
        $confirmModel->make();

        return $this->entityManager;
    }
}