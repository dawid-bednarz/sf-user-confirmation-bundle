<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Service;

use DawBed\PHPUserActivateToken\Model\ConfirmModel;
use DawBed\PHPUserActivateToken\Model\Criteria\ConfirmCriteria;
use DawBed\UserBundle\Service\EntityService;
use DawBed\UserConfirmationBundle\Repository\UserActiveTokenRepository;
use Doctrine\ORM\EntityManagerInterface;

class ConfirmationService
{
    private $entityManager;
    private $repository;
    private $userEntityService;

    function __construct(UserActiveTokenRepository $repository, EntityManagerInterface $entityManager, EntityService $userEntityService)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->userEntityService = $userEntityService;
    }

    public function prepareModel(ConfirmCriteria $criteria): ConfirmModel
    {
        $userActivateToken = $this->repository->findToConfirm($criteria->getToken());

        return new ConfirmModel($userActivateToken, new $this->userEntityService->UserStatus, $criteria->getStatus());
    }

    public function make(ConfirmModel $confirmModel): EntityManagerInterface
    {
        $confirmModel->make();

        return $this->entityManager;
    }
}