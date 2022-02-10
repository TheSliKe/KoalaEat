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

class DashboardLivreurController extends AbstractController
{
    #[Route('/dashboard/livreur', name: 'dashboard_livreur')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repositoryCommande = $entityManager->getRepository(Commande::class);
        $commande = $repositoryCommande->findAll();
        $repositoryRestauratnt= $entityManager->getRepository(Restaurant::class);
        $restaurant = $repositoryRestauratnt->findAll();
        $repositoryPossede = $entityManager->getRepository(Possede::class);
        $possede = $repositoryPossede->findAll();
        $repositoryPlat= $entityManager->getRepository(Plat::class);
        $plat = $repositoryPlat->findOneBy(['']);
        $conn = $entityManager->getConnection();
        $sql = '
                SELECT commande.* FROM commande 
                LEFT JOIN compose ON compose.fk_co_id = commande.id
                LEFT JOIN plat ON plat.id = compose.fk_pa_id
                WHERE  plat.fk_re_id = :id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);
        dump($resultSet->fetchAllAssociative());


        return $this->render('dashboard_livreur/index.html.twig', [
            'commandes' => $commande,
            'restaurants' => $restaurant,
            'possedes' => $possede
        ]);
    }
}
