<?php

namespace App\Repository;

use App\Entity\PClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method PClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method PClient[]    findAll()
 * @method PClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PClient::class);
    }

    // /**
    //  * @return PClient[] Returns an array of PClient objects
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
    public function findOneBySomeField($value): ?PClient
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
