<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Service\Token;

use DawBed\PHPUserActivateToken\Model\Criteria\CreateCriteria;
use DawBed\PHPUserActivateToken\Model\CreateModel;
use DawBed\UserConfirmationBundle\Service\EntityService;
use DawBed\UserConfirmationBundle\Service\TokenService;
use Doctrine\ORM\EntityManagerInterface;

class CreateService
{
    private $entityManager;
    private $tokenService;
    private $entityService;

    function __construct(EntityManagerInterface $entityManager, EntityService $entityService, TokenService $tokenService)
    {
        $this->entityManager = $entityManager;
        $this->tokenService = $tokenService;
        $this->entityService = $entityService;
    }

    public function prepareModel(CreateCriteria $criteria): CreateModel
    {
        return new CreateModel(
            new $this->entityService->UserActivateToken($criteria->getContext()),
            $criteria->getUser(),
            $this->tokenService->generate($criteria->getSettings())
        );
    }

    public function make(CreateModel $createModel): EntityManagerInterface
    {
        $createModel->make();
        $this->entityManager->persist($createModel->getEntity());

        return $this->entityManager;
    }
}