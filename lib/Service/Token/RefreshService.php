<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Service\Token;

use DawBed\PHPUserActivateToken\Model\Criteria\CreateCriteria;
use DawBed\PHPUserActivateToken\Model\Criteria\RefreshCriteria;
use DawBed\PHPUserActivateToken\Model\RefreshModel;
use DawBed\PHPUserActivateToken\UserActivateToken;
use DawBed\UserConfirmationBundle\Repository\UserActiveTokenRepository;
use DawBed\UserConfirmationBundle\Service\TokenService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnexpectedResultException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class RefreshService
{
    private $entityManager;
    private $tokenService;
    private $activeTokenRepository;

    function __construct(EntityManagerInterface $entityManager,
                         TokenService $tokenService,
                         UserActiveTokenRepository $activeTokenRepository)
    {
        $this->entityManager = $entityManager;
        $this->tokenService = $tokenService;
        $this->activeTokenRepository = $activeTokenRepository;
    }

    public function prepareModel(CreateCriteria $criteria): RefreshModel
    {
        $activateToken = $this->activeTokenRepository->findToRefresh($criteria);

        return new RefreshModel(
            $activateToken ?? new UserActivateToken($criteria->getContext()),
            $criteria->getUser(),
            $criteria->getSettings()
        );
    }

    public function make(RefreshModel $model): EntityManagerInterface
    {
        if (is_null($model->getToken())) {
            $token = $this->tokenService->generate($model->getTokenSetting());
        } else {
            $token = $this->tokenService->refresh($model->getToken(), $model->getTokenSetting());
        }

        $model->make($token);

        $this->entityManager->persist($model->getEntity());

        return $this->entityManager;
    }
}