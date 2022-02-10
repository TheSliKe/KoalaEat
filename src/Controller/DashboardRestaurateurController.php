<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Status;
use App\Entity\Restaurateur;
use App\Entity\Restaurant;
use App\Entity\Possede;
use App\Entity\Commande;
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
            if($request->get('idCmd')){
                $repositoryStatut = $entityManager->getRepository(Status::class);
                $status = $repositoryStatut->findOneBy(['id' => 4]);
                $repositoryCommande = $entityManager->getRepository(Commande::class);
                $Commande = $repositoryCommande->findOneBy(['id' => $request->get('idCmd')]);
                $possede = new Possede();
                $now=new \DateTime();
                $possede->setPODate($now);
                $possede->setFKST($status);
                $possede->setFKCO($Commande);
                $entityManager->persist($possede);
                $entityManager->flush();
            }
        }

        if($request->isMethod('post')){
            if($request->get('idPlat')){
                $repositoryPlat = $entityManager->getRepository(Plat::class);
                $plat = $repositoryPlat->findOneBy(['id' => $_POST['idPlat']]);
                $plat->setEstSupprime(true);
                $entityManager->persist($plat);
                $entityManager->flush();
            }
        }

        $sql = '
                SELECT distinct
                    commande.id as id, 
                    status.st_libelle as st_libelle,
                    possede.po_date as po_date
                    FROM commande 
                    INNER JOIN possede 
                    ON commande.id = possede.fk_co_id
                    LEFT JOIN status
                    ON status.id = possede.fk_st_id
                    Left JOIN restaurant
                    ON restaurant.id 
                    AND commande.fk_restaurant_id
                    WHERE commande.fk_restaurant_id = :id
                    AND status.id != 2
                    AND possede.po_date IN 
                    (
                        SELECT max(possede.po_date) 
                        FROM possede 
                        GROUP BY possede.fk_co_id
                    )
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
 