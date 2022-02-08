<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilLivreurController extends AbstractController
{
    #[Route('/profil/livreur', name: 'profil_livreur')]
    public function index(): Response
    {
        return $this->render('profil_livreur/index.html.twig', [
            'controller_name' => 'ProfilLivreurController',
        ]);
    }
}
