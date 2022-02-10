<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class DetailCommandeController extends AbstractController
{
    #[Route('/detail/commande/{id}', name: 'detail_commande')]
    public function index(Request $request, EntityManagerInterface $entityManager, $id): Response
    {

        $repositoryCommande = $entityManager->getRepository(Commande::class);
        $commande = $repositoryCommande->findOneBy(['id' => $id]);

        $plats = $commande->getComposes();
        $status = $commande->getPossedes();

        return $this->render('detail_commande/index.html.twig', [
            //'DetailCommandeType' => $form1->createView(),
            'commande' => $commande,
            'plats' => $plats,
            'controller_name' => 'DetailCommandeController', 
            'statusList' => $status
        ]);
    }
}