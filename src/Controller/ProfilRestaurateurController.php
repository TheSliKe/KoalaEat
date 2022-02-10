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
        // $user_id = $this->getUser();
        
        // $query = $entityManager->createQuery(
        //             'SELECT p.id
        //             FROM App\Entity\Restaurateur p
        //             WHERE p.id = :id'
        // )->setParameter('id', $user_id);
        //   $query->getResult()
        // $restaurateur = $entityManager->getRepository(Restaurateur::class)->find(2);
        $restaurateur = $entityManager->find(Restaurateur::class, 1);
        // $restaurateur = $this->getDoctrine()->getRepository(Article::class)->find(2);


        $restaurant = new Restaurant();
        $HoraireRestaurant = new HoraireRestaurant();
        
        $form1 = $this->createForm(ProfilRestaurateurFormType::class, $restaurateur);
        $form2 = $this->createForm(CreerRestaurantType::class, $restaurant);
        $form3 = $this->createForm(RestaurantHoraireType::class, $HoraireRestaurant);
        $form1->handleRequest($request);
        $form2->handleRequest($request);
        $form3->handleRequest($request);

        
        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager->persist($restaurateur);
            $entityManager->flush();
        }
        return $this->render('profil_restaurateur/index.html.twig', [
            'ProfilRestaurateurForm' => $form1->createView(), 
            'CreerRestaurantType' => $form2->createView(),
            'RestaurantHoraireType' => $form3->createView(),
            
        ]);
    }
}