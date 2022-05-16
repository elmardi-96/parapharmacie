<?php

namespace App\Repository;

use App\Entity\UserAffectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserAffectation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAffectation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAffectation[]    findAll()
 * @method UserAffectation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAffectationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAffectation::class);
    }

    // /**
    //  * @return UserAffectation[] Returns an array of UserAffectation objects
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

    /*
    public function findOneBySomeField($value): ?UserAffectation
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
