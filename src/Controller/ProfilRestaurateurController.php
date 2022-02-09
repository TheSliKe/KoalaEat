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
    
        $restaurateur = new Restaurateur();
        $restaurant = new Restaurant();
        $HoraireRestaurant = new HoraireRestaurant();
        $form = $this->createForm(ProfilRestaurateurFormType::class, $restaurateur);
        $form2 = $this->createForm(CreerRestaurantType::class, $restaurant);
        $form3 = $this->createForm(RestaurantHoraireType::class, $HoraireRestaurant);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        $form3->handleRequest($request);
        
        $restaurateurName = $restaurateur->getRESNom();
        $restaurateurPrenom = $restaurateur->getRESPrenom();
        $restaurateurMail = $restaurateur->getRESMail();
        $restaurateurTel = $restaurateur->getRESTelephone();
        $restaurateurAdresse = $restaurateur->getRESAdresse();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($restaurateur);
            $entityManager->flush();
        }
        return $this->render('profil_restaurateur/index.html.twig', [
            'ProfilRestaurateurForm' => $form->createView(), 
            'CreerRestaurantType' => $form2->createView(),
            'RestaurantHoraireType' => $form3->createView(),
            'restaurateurName' => $restaurateurName, 
            'restaurateurPrenom' => $restaurateurPrenom, 
            'restaurateurMail' => $restaurateurMail, 
            'restaurateurTel' => $restaurateurTel,
            'restaurateurAdresse' => $restaurateurAdresse
        ]);
    }
}