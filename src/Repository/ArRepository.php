<?php

namespace App\Repository;

use App\Entity\Ar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ar[]    findAll()
 * @method Ar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ar::class);
    }

    // /**
    //  * @return Ar[] Returns an array of Ar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ar
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
