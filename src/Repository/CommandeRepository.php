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
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    // public function findnotlivrer($idcommande): Collection
    // {
    //     return $this->createQueryBuilder('c')
    //         ->join(Possede::class, 'p')
    //         ->where('p.FK_ST = 2')
    //         ->where('c.FK_CO = :val')
    //         ->setParameter('val', $idcommande)
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