<?php

namespace App\Repository;

use App\Entity\VLivraisondet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VLivraisondet|null find($id, $lockMode = null, $lockVersion = null)
 * @method VLivraisondet|null findOneBy(array $criteria, array $orderBy = null)
 * @method VLivraisondet[]    findAll()
 * @method VLivraisondet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VLivraisondetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VLivraisondet::class);
    }

    // /**
    //  * @return VLivraisondet[] Returns an array of VLivraisondet objects
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
    public function findOneBySomeField($value): ?VLivraisondet
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
