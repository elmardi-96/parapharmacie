<?php

namespace App\Repository;

use App\Entity\PFornisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PFornisseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method PFornisseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method PFornisseur[]    findAll()
 * @method PFornisseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PFornisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PFornisseur::class);
    }

    // /**
    //  * @return PFornisseur[] Returns an array of PFornisseur objects
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
    public function findOneBySomeField($value): ?PFornisseur
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
