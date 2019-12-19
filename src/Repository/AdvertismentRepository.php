<?php

namespace App\Repository;

use App\Entity\Advertisment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Advertisment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advertisment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advertisment[]    findAll()
 * @method Advertisment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertismentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advertisment::class);
    }


}
