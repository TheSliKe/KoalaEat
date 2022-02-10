<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Restaurateur;
use App\Entity\Restaurant;
use App\Form\CreerPlatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class DashboardRestaurateurController extends AbstractController
{

    #[Route('/dashboard/restaurateur', name: 'dashboard_restaurateur')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user_id = $this->getUser();

        $repository = $entityManager->getRepository(Restaurateur::class);
        $restaurateur = $repository->findOneBy(['FK_US' => $user_id]);

        $listeRestaurant = $restaurateur->getRestaurants();
        
        return $this->render('dashboard_restaurateur/index.html.twig', [
            'controller_name' => 'DashboardRestaurateurController',
            'listeRestaurant' => $listeRestaurant
        ]);
    }

    #[Route('/dashboard/restaurant/view/{id}', name: 'dashboard_restaurant')]
    public function dashboard_restaurant(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $conn = $entityManager->getConnection();

        if($request->isMethod('post')){
            $repositoryPlat = $entityManager->getRepository(Plat::class);
            $plat = $repositoryPlat->findOneBy(['id' => $_POST['idPlat']]);
            $plat->setEstSupprime(true);
            $entityManager->persist($plat);
            $entityManager->flush();
        }

        $sql = '
                SELECT distinct
                    commande.id as id, 
                    status.st_libelle as st_libelle,
                    max(possede.po_date)
                FROM commande 
                    LEFT JOIN compose ON compose.fk_co_id = commande.id
                    INNER JOIN possede ON commande.id = possede.fk_co_id
                    LEFT JOIN status ON status.id = possede.fk_st_id
                    LEFT JOIN plat ON plat.id = compose.fk_pa_id
                WHERE  plat.fk_re_id = :id
                    AND status.id <> 2
                GROUP by commande.id,
                    status.st_libelle,
                    possede.po_date
                having possede.po_date;
            ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);
        $commandes = $resultSet->fetchAllAssociative();
 
        $repositoryPlat = $entityManager->getRepository(Plat::class);
        $plats = $repositoryPlat->findBy(['FK_RE' => 1, 'estSupprime' => 0]);
        return $this->render('dashboard_restaurant/index.html.twig', [
            'plats' => $plats,
            'commandes' => $commandes
        ]);
    }

    #[Route('/dashboard/restaurant/plat/{id}', name: 'dashboard_restaurant_edit')]
    public function edit_dashboard_restaurant(Request $request, EntityManagerInterface $entityManager, $id): Response
    {

        if($id==0){
            $plat = new Plat();
        } else {
            $repositoryPlat = $entityManager->getRepository(Plat::class);
            $plat = $repositoryPlat->findOneBy(['id' => $id]);
        }
        $repositoryRestaurant = $entityManager->getRepository(Restaurant::class);
        $restaurants = $repositoryRestaurant->findBy(['FK_RES_id' => 1]);
        

        $form1 = $this->createForm(
            CreerPlatType::class, 
            $plat,
            array('restaurant' => $restaurants)
        );


        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager->persist($plat);
            $entityManager->flush();
        }

        return $this->render('dashboard_restaurant_edit/index.html.twig', [
            'creerPlatType' => $form1->createView(),
            'plats' => $plat,
        ]);
    }
}
 