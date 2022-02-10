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

    public function getCommande($client){

        $conn = $this->getEntityManager()->getConnection();
        $sql = '
                SELECT c.id as id, st.st_libelle as status, po.po_date as date FROM commande c
                inner join possede po on po.fk_co_id = c.id
                inner join status st on po.fk_st_id = st.id
                Where c.fk_cl_id = :id and  po.po_date in ( select max(po.po_date) from possede po group by po.fk_co_id ) 
                GROUP BY c.id, st.st_libelle, po.po_date;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([':id' => $client]);
        return $resultSet->fetchAllAssociative();

        // $qb = $this->createQueryBuilder('c')
        //             ->innerJoin(Possede::class, 'po')
        //             ->addSelect("po")
        //             ->where("c.FK_CL = :client")
        //             ->groupBy("c.id , po.id")
        //             ->setParameters([ 'client' => $client ])
        //             ->getQuery();
        
        // $qb->execute();
        // return $qb->getResult();
    }

    public function getCommandeEnCours($client){

        $conn = $this->getEntityManager()->getConnection();
        $sql = '
                SELECT c.id as id, st.st_libelle as status, po.po_date as date FROM commande c
                inner join possede po on po.fk_co_id = c.id
                inner join status st on po.fk_st_id = st.id
                Where c.fk_cl_id = :id and  po.po_date in ( select max(po.po_date) from possede po group by po.fk_co_id ) AND st.st_libelle != "Livrée"
                GROUP BY c.id, st.st_libelle, po.po_date;
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([':id' => $client]);
        return $resultSet->fetchAllAssociative();
        
    }

    public function getCommandeLivreurAcceptéParRestau($livreur){

        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            select c.id as id, 
                re.re_adresse as restaurantAdresse, 
                po.po_date as dateCommande, 
                c.co_adresse_de_livraison as livraisonAdresse
            FROM commande c
            INNER JOIN possede po ON c.id = po.fk_co_id
            LEFT JOIN restaurant re ON re.id = c.fk_restaurant_id
            where po.fk_st_id = 2 
            AND re.fk_vi_id_id = :idLivreurVille
            AND po.po_date in (select max(possede.po_date) 
            FROM possede 
            group by possede.fk_co_id);
        ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([':idLivreurVille' => $livreur->getFKVI()->getId()]);
        return $resultSet->fetchAllAssociative();
        
    }

    public function getCommandeLivreurPriseEnCharge($livreur){

        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            select c.id as id, 
                re.re_adresse as restaurantAdresse, 
                po.po_date as dateCommande, 
                c.co_adresse_de_livraison as livraisonAdresse,
                st.st_libelle as status
            FROM commande c
            INNER JOIN possede po ON c.id = po.fk_co_id
            LEFT JOIN restaurant re ON re.id = c.fk_restaurant_id
            LEFT JOIN status st ON st.id = po.fk_st_id
            where 
                po.po_date in (select max(possede.po_date)
                    from possede group by possede.fk_co_id)
            AND fk_li_id = :idLivreur
            AND po.fk_st_id IN (3, 4, 5, 6) ;
        ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([':idLivreur' => $livreur->getId()]);
        return $resultSet->fetchAllAssociative();
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

    // /**
    //  * @return Collection[] Returns an array of Commande objects
    //  */
    // public function findByiD($id): ?Collection {
    //     return $this->createQueryBuilder('c')
    //         ->select('c.id as id')
    //         ->addSelect('s.ST_Libelle as st_libelle')
    //         ->leftJoin(Compose::class, 'v')
    //         ->innerJoin(Possede::class, 'p')
    //         ->leftJoin(Status::class, 's')
    //         ->leftJoin(Plat::class, 'n')
    //         ->where('n.FK_RE = :id')
    //         ->setParameter(':id', $id)
    //         ->getQuery()
    //         ->getResult();
    // }
    
    // public function getCommandeEtStatus($id) {
    //     $conn = $this->getEntityManager()->getConnection();
    //     $sql = '
    //             SELECT distinct
    //                 commande.id as id, 
    //                 status.st_libelle as st_libelle,
    //                 possede.po_date as po_date,
    //                 status.id as status_id
    //             FROM commande 
    //             INNER JOIN possede 
    //             ON commande.id = possede.fk_co_id
    //             LEFT JOIN status
    //             ON status.id = possede.fk_st_id
    //             Left JOIN restaurant
    //             ON restaurant.id 
    //             AND commande.fk_restaurant_id
    //             WHERE commande.fk_restaurant_id = :id
    //             AND status.id != 7
    //             AND possede.po_date IN 
    //             (
    //                 SELECT max(possede.po_date) 
    //                 FROM possede 
    //                 GROUP BY possede.fk_co_id
    //             )
    //         ';
    //     $stmt = $conn->prepare($sql);
    //     $resultSet = $stmt->executeQuery([':id' => $id]);
    //     return $resultSet->fetchAllAssociative();
    // }
    
    
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