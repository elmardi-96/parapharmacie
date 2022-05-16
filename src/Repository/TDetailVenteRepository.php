<?php

namespace App\Repository;

use App\Entity\TDetailVente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TDetailVente|null find($id, $lockMode = null, $lockVersion = null)
 * @method TDetailVente|null findOneBy(array $criteria, array $orderBy = null)
 * @method TDetailVente[]    findAll()
 * @method TDetailVente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TDetailVenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TDetailVente::class);
    }

    // /**
    //  * @return TDetailVente[] Returns an array of TDetailVente objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TDetailVente
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
