<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\UserConfirmationBundle\Repository;

use DawBed\PHPToken\TokenInterface;
use DawBed\PHPUserActivateToken\Model\Criteria\CreateCriteria;
use DawBed\PHPUserActivateToken\Model\Criteria\RefreshCriteria;
use DawBed\PHPUserActivateToken\UserActivateToken;
use DawBed\PHPUserActivateToken\UserActivateTokenInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserActiveTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, $entityClass = UserActivateToken::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function findToConfirm(TokenInterface $token): ?UserActivateTokenInterface
    {
        $qb = $this->createQueryBuilder('uat');

        $qb->join('uat.user', 'user')
            ->join('uat.token', 'token');

        $qb->where('token=:token')
            ->setParameter('token', $token);

        return $qb->getQuery()->getSingleResult();
    }

    public function findToRefresh(CreateCriteria $criteria): ?UserActivateTokenInterface
    {
        $qb = $this->createQueryBuilder('uat');

        return $qb->leftJoin('uat.token', 'token')
            ->where('uat.user=:user')
            ->andWhere('uat.context=:context')
            ->setParameter('user', $criteria->getUser())
            ->setParameter('context', $criteria->getContext())
            ->getQuery()
            ->getOneOrNullResult();
    }
}