<?php

namespace App\Controller;

use App\Entity\Restaurateur;
use App\Entity\Restaurant;
use App\Entity\HoraireRestaurant;
use App\Form\ProfilRestaurateurFormType;
use App\Form\CreerRestaurantType;
use App\Form\RestaurantHoraireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilRestaurateurController extends AbstractController
{
    #[Route('/profil/restaurateur', name: 'profil_restaurateur')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user_id = $this->getUser();

        $repository = $entityManager->getRepository(Restaurateur::class);
        $restaurateur = $repository->findOneBy(['FK_US' => $user_id]);

        $form1 = $this->createForm(ProfilRestaurateurFormType::class, $restaurateur);
        $form1->handleRequest($request);
        
        $listeRestaurant = $restaurateur->getRestaurants();

        
        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager->persist($restaurateur);
            $entityManager->flush();
        }
        return $this->render('profil_restaurateur/index.html.twig', [
            'ProfilRestaurateurForm' => $form1->createView(), 
            'listeRestaurant' => $listeRestaurant
        ]);
    }

    #[Route('/profil/restaurateur/restaurant', name: 'edition_restaurant')]
    public function test(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $restaurant = new Restaurant();
        $HoraireRestaurant = new HoraireRestaurant();

        $form2 = $this->createForm(CreerRestaurantType::class, $restaurant);
        $form3 = $this->createForm(RestaurantHoraireType::class, $HoraireRestaurant);

        $form2->handleRequest($request);
        $form3->handleRequest($request);
        return $this->render('edition_restaurant/index.html.twig', [                
            'CreerRestaurantType' => $form2->createView(),
            'RestaurantHoraireType' => $form3->createView(),
        ]);
    }
}