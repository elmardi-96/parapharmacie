<?php

namespace App\Repository;

use App\Entity\PDossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PDossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method PDossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method PDossier[]    findAll()
 * @method PDossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PDossierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PDossier::class);
    }

    // /**
    //  * @return PDossier[] Returns an array of PDossier objects
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
    public function findOneBySomeField($value): ?PDossier
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getNb() {
 
        return $this->createQueryBuilder('p')
 
                        ->select('COUNT(p)')
 
                        ->getQuery()
 
                        ->getSingleScalarResult();
 
    }
}
