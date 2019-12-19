<?php

namespace App\Repository;

use App\Entity\UserService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserService|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserService|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserService[]    findAll()
 * @method UserService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserService::class);
    }

    // /**   $count++;
    //  * @return UserService[] Returns an array of UserService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function getLastIds($count)
    {
        return $this->createQueryBuilder('u')
            ->select('u.id')
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ->setMaxResults($count)
            ->getResult()
            ;
    }

    public function getOrderedServices($arrayFolloweeIds)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('s')
            ->where("s.id IN(:followeeIds)")
            ->setParameter('followeeIds', array_values($arrayFolloweeIds))
            ->orderBy('s.id','DESC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getActiveServices($user)
    {
        return $this->createQueryBuilder('s')
        ->addSelect('s')
            ->where("s.user = :user")
            ->andWhere("s.isActive = 1")
        ->setParameter('user', $user)
        ->orderBy('s.serviceStartDate','DESC')
        ->getQuery()
        ->getResult()
    ;
    }
}
