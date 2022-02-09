<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardRestaurateurController extends AbstractController
{
    #[Route('/dashboard/restaurateur', name: 'dashboard_restaurateur')]
    public function index(): Response
    {
        return $this->render('dashboard_restaurateur/index.html.twig', [
            'controller_name' => 'DashboardRestaurateurController',
        ]);
    }
}
