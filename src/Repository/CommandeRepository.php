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

    public function getCommandeEtStatus($id) {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
                SELECT distinct
                    commande.id as id, 
                    status.st_libelle as st_libelle,
                    possede.po_date as po_date,
                    status.id as status_id
                FROM commande 
                INNER JOIN possede 
                ON commande.id = possede.fk_co_id
                LEFT JOIN status
                ON status.id = possede.fk_st_id
                Left JOIN restaurant
                ON restaurant.id 
                AND commande.fk_restaurant_id
                WHERE commande.fk_restaurant_id = :id
                AND status.id != 7
                AND possede.po_date IN 
                (
                    SELECT max(possede.po_date) 
                    FROM possede 
                    GROUP BY possede.fk_co_id
                )
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([':id' => $id]);
        return $resultSet->fetchAllAssociative();
    }
    
    
    public function getCommandesDetailsLivreur($id){
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
                SELECT commande.* FROM commande 
                LEFT JOIN compose ON compose.fk_co_id = commande.id
                LEFT JOIN plat ON plat.id = compose.fk_pa_id
                WHERE  plat.fk_re_id = :id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([':id' => $id]);
        return $resultSet->fetchAllAssociative();
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