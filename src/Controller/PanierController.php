<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Compose;
use App\Entity\Plat;
use App\Entity\Possede;
use App\Entity\Restaurant;
use App\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier', methods : ['POST'])]
    public function index(SessionInterface $session, Request $request, EntityManagerInterface $entityManager): Response
    {
        $repoPlat = $entityManager->getRepository(Plat::class);
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $info = [];

            $plats = $session->get("panier");
            foreach ($plats as $pl) {
                $platSelection = $repoPlat->find($pl['id']);
                $restaurant = $platSelection->getFKRE();
                array_push($info, [
                    "id" => $pl['id'],
                    "Plat" => $platSelection->getPALibelle(),
                    "Quantite" => $pl['quantite'],
                    "Prix" => $platSelection->getPAPrix(),
                    "RestaurantId" => $restaurant->getId()
                ]);
            }
            return new JsonResponse($info); 
         } else { 
            return $this->redirect('/dashboard/client'); 
         }
    }

    #[Route('/panier/add', name: 'panier_add',  methods : ['POST'])]
    public function add(SessionInterface $session, Request $request, EntityManagerInterface $entityManager) : Response
    {   
        $repoPlat = $entityManager->getRepository(Plat::class);
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $info = [];
            $panier = $session->get("panier", []);
            $id = $repoPlat->find($_POST['id'])->getId();
            $quantite = $_POST['quantite'];
            
            if (!empty($panier[$id])) {
                $panier[$id] = [
                    "id" => $id,
                    "quantite" => $panier[$id]['quantite'] + $quantite
                ];
            } else {
                $panier[$id] = [
                    "id" => $id,
                    "quantite" => $quantite
                ];
            }

            $session->set('panier', $panier);
            $plats = $session->get("panier");

            foreach ($plats as $pl) {
                $platSelection = $repoPlat->find($pl['id']);
                $restaurant = $platSelection->getFKRE();
                array_push($info, [
                    "id" => $pl['id'],
                    "Plat" => $platSelection->getPALibelle(),
                    "Quantite" => $pl['quantite'],
                    "Prix" => $platSelection->getPAPrix(),
                    "RestaurantId" => $restaurant->getId()
                ]);
            }
            return new JsonResponse($info); 
         } else { 
            return $this->redirect('/dashboard/client'); 
         }
    }

    #[Route('/panier/remove', name: 'panier_remove',  methods : ['POST'])]
    public function remove(SessionInterface $session, Request $request, EntityManagerInterface $entityManager) : Response
    {   
        $repoPlat = $entityManager->getRepository(Plat::class);
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $info = [];
            $panier = $session->get("panier", []);
            $id = $repoPlat->find($_POST['id'])->getId();
            // $quantite = $_POST['quantite'];
            
            // if (!empty($panier[$id])) {
            //     if($panier[$id]['quantite'] > 1){
            //         $panier[$id]['quantite']--;
            //     }else{
            //         unset($panier[$id]);
            //     }
            // }
            unset($panier[$id]);

            $session->set('panier', $panier);
            $plats = $session->get("panier");

            foreach ($plats as $pl) {
                $platSelection = $repoPlat->find($pl['id']);
                $restaurant = $platSelection->getFKRE();
                array_push($info, [
                    "id" => $pl['id'],
                    "Plat" => $platSelection->getPALibelle(),
                    "Quantite" => $pl['quantite'],
                    "Prix" => $platSelection->getPAPrix(),
                    "RestaurantId" => $restaurant->getId()
                ]);
            }
            return new JsonResponse($info); 
         } else { 
            return $this->redirect('/dashboard/client'); 
         }
    }

    #[Route('/panier/vider', name: 'panier_vider',  methods : ['POST'])]
    public function viderPanier(SessionInterface $session, Request $request, EntityManagerInterface $entityManager) : Response
    {   
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $session->set("panier", []);
            
            return new JsonResponse("Panier Vider"); 
         } else { 
            return $this->redirect('/dashboard/client'); 
         }
    }

    #[Route('/panier/valider', name: 'panier_valider',  methods : ['POST'])]
    public function validerPanier(SessionInterface $session, Request $request, EntityManagerInterface $entityManager) : Response
    {   
        $user_id = $this->getUser();
        $restaurantId = $_POST['restaurantId'];
        
        $repository = $entityManager->getRepository(Restaurant::class);
        $restaurant = $repository->find($restaurantId); 
        
        $repository = $entityManager->getRepository(Client::class);
        $client = $repository->findOneBy(['FK_US' => $user_id]); 
        
        $repoStatus = $entityManager->getRepository(Status::class);
        $status= $repoStatus->find('1');

        $repoPlat = $entityManager->getRepository(Plat::class);

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $panier = $session->get("panier", []);

            //Inserer dans commande
            $commande = new Commande();
            $commande->setFKCL($client);
            $commande->setCOAdresseDeLivraison($client->getCLAdresse());
            $commande->setFkRestaurant($restaurant);
            $entityManager->persist($commande);

            //Inserer Possede
            $possede = new Possede();
            $possede->setFKCO($commande);
            $possede->setFKST($status);
            $possede->setPODate(new \DateTime('NOW'));
            $entityManager->persist($possede);

            foreach ($panier as $pl) {
            //Inserer dans Compose
               $plat = $repoPlat->find($pl['id']);
               if ($plat->getFKRE() ==  $restaurant) {
                    $oldStock = $plat->getPAStock();
                    $newQuantite = $plat->setPAStock($oldStock - $pl['quantite']);

                    $compose = new Compose();
                    $compose->setFKPA($plat);
                    $compose->setFKCO($commande);
                    $compose->setCOQuantite($pl['quantite']);
                    $entityManager->persist($compose);
                    $entityManager->persist($newQuantite);
                }
            }

            $commande->setFkRestaurant($restaurant);
            $entityManager->persist($commande);

            $entityManager->flush();

            $session->set("panier", []);
            return new JsonResponse("Panier Valider"); 
         } else { 
            return $this->redirect('/dashboard/client'); 
         }
    }
}
