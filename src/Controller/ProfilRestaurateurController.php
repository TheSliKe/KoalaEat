<?php

namespace App\Controller;

use App\Entity\Restaurateur;
use App\Entity\Restaurant;
use App\Form\ProfilRestaurateurFormType;
use App\Form\CreerRestaurantType;
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
        
        $restaurateur = new Restaurateur();
        $restaurant = new Restaurant();

        $form = $this->createForm(ProfilRestaurateurFormType::class, $restaurateur);
        $form2 = $this->createForm(CreerRestaurantType::class, $restaurant);
        $form->handleRequest($request);
        $form2->handleRequest($request);

        $restaurateurName = "FRUGRE";
        $restaurateurPrenom = "MICHEL";
        $restaurateurMail = "J.M@JAIME.GEMO";
        $restaurateurTel = "0669696969";
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($restaurateur);
            $entityManager->flush();
        }
        return $this->render('profil_restaurateur/index.html.twig', [
            'ProfilRestaurateurForm' => $form->createView(), 
            'CreerRestaurantType' => $form2->createView(),
            'restaurateurName' => $restaurateurName, 
            'restaurateurPrenom' => $restaurateurPrenom, 
            'restaurateurMail' => $restaurateurMail, 
            'restaurateurTel' => $restaurateurTel
        ]);
    }
}