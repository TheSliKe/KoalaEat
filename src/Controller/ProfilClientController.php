<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilClientController extends AbstractController
{
    #[Route('/profil/client', name: 'profil_client')]
    public function index(): Response
    {
        return $this->render('profil_client/index.html.twig', [
            'controller_name' => 'ProfilClientController',
        ]);

    }
}
