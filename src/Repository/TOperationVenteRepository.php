<?php

namespace App\Repository;

use App\Entity\TOperationVente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TOperationVente|null find($id, $lockMode = null, $lockVersion = null)
 * @method TOperationVente|null findOneBy(array $criteria, array $orderBy = null)
 * @method TOperationVente[]    findAll()
 * @method TOperationVente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TOperationVenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TOperationVente::class);
    }

    // /**
    //  * @return TOperationVente[] Returns an array of TOperationVente objects
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
    public function findOneBySomeField($value): ?TOperationVente
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
