<?php

namespace App\Repository;

use App\Entity\VLivraisoncab;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VLivraisoncab|null find($id, $lockMode = null, $lockVersion = null)
 * @method VLivraisoncab|null findOneBy(array $criteria, array $orderBy = null)
 * @method VLivraisoncab[]    findAll()
 * @method VLivraisoncab[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VLivraisoncabRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VLivraisoncab::class);
    }

    // /**
    //  * @return VLivraisoncab[] Returns an array of VLivraisoncab objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VLivraisoncab
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
