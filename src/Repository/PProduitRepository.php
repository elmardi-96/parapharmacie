<?php

namespace App\Repository;

use App\Entity\PProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method PProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method PProduit[]    findAll()
 * @method PProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PProduit::class);
    }

    // /**
    //  * @return PProduit[] Returns an array of PProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PProduit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
