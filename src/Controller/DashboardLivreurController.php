<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;
use App\Entity\Restaurant;
use App\Entity\Possede;
use App\Entity\Plat;

class DashboardLivreurController extends AbstractController
{
    #[Route('/dashboard/livreur', name: 'dashboard_livreur')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $conn = $entityManager->getConnection();
        $sql = '
        select c.id as id, 
                re.re_adresse as restaurantAdresse, 
                po.po_date as dateCommande, 
                c.co_adresse_de_livraison as livraisonAdresse
            FROM commande c
                INNER JOIN possede po ON c.id = po.fk_co_id
                LEFT JOIN restaurant re ON re.id = c.fk_restaurant_id
            where po.fk_st_id = 2 AND po.po_date in (select max(possede.po_date) from possede group by possede.fk_co_id); 
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $result = $resultSet->fetchAllAssociative();
        
        $sql2 = '
        select c.id as id, 
        re.re_adresse as restaurantAdresse, 
        po.po_date as dateCommande, 
        c.co_adresse_de_livraison as livraisonAdresse
    FROM commande c
        INNER JOIN possede po ON c.id = po.fk_co_id
        LEFT JOIN restaurant re ON re.id = c.fk_restaurant_id
    where po.fk_st_id = 5 AND po.fk_st_id = 6 AND po.po_date in (select max(possede.po_date) from possede group by possede.fk_co_id);
            ';
        $stmt2 = $conn->prepare($sql2);
        $resultSet2 = $stmt2->executeQuery();
        $result2 = $resultSet2->fetchAllAssociative();

        return $this->render('dashboard_livreur/index.html.twig', [
            'commandes' => $result,
            'commandesPreiseEnCharge' => $result2
        ]);
    }
}
