<?php

namespace App\Repository;

use App\Entity\Restaurateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurateur[]    findAll()
 * @method Restaurateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurateur::class);
    }

    // /**
    //  * @return Restaurateur[] Returns an array of Restaurateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restaurateur
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
