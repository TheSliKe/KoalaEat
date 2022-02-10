<?php

namespace App\Repository;

use App\Entity\Commande;
use App\Entity\Compose;
use App\Entity\Possede;
use App\Entity\Status;
use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Commande[]    getCommandesListing(int $id)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Collection[] Returns an array of Commande objects
    //  */
    // public function findByiD($id): ?Collection {
    //     return $this->createQueryBuilder('c')
    //         ->select('c.id as id')
    //         ->addSelect('s.ST_Libelle as st_libelle')
    //         ->leftJoin(Compose::class, 'v')
    //         ->leftJoin(Possede::class, 'p')
    //         ->leftJoin(Status::class, 's')
    //         ->leftJoin(Plat::class, 'n')
    //         ->where('n.FK_RE = :id')
    //         ->setParameter(':id', $id)
    //         ->getQuery()
    //         ->getResult();
    // }
    
    // /**
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    // public function findByExampleField($value)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('c.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    /*
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}