<?php

namespace App\Repository;

use App\Entity\PArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method PArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method PArticle[]    findAll()
 * @method PArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PArticle::class);
    }

    // /**
    //  * @return PArticle[] Returns an array of PArticle objects
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
    public function findOneBySomeField($value): ?PArticle
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
