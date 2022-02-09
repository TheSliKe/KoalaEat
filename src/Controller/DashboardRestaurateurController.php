<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Restaurateur;
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

    #[Route('/dashboard/restaurant/{id}', name: 'dashboard_restaurant')]
    public function dashboard_restaurant(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plat = new Plat();

        $form1 = $this->createForm(CreerPlatType::class, $plat);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager->persist($plat);
            $entityManager->flush();
        }
        
        return $this->render('dashboard_restaurant/index.html.twig', [
            'creerPlatType' => $form1->createView()
        ]);
    }
}