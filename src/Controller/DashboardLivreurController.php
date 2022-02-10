<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;
use App\Entity\Livreur;
use App\Entity\Possede;
use App\Entity\Status;
use App\Entity\Plat;

class DashboardLivreurController extends AbstractController
{
    #[Route('/dashboard/livreur', name: 'dashboard_livreur')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repositoryStatus = $entityManager->getRepository(Status::class);
        $repositoryLivreur = $entityManager->getRepository(Livreur::class);
        $livreur = $repositoryLivreur->find(1);

        $repositoryCommande = $entityManager->getRepository(Commande::class);
        $commandesAttentePrisEnCharge = $repositoryCommande->getCommandeLivreurAcceptéParRestau($livreur);
        $commandesPrisEnCharge = $repositoryCommande->getCommandeLivreurPriseEnCharge($livreur);

        if ($request->isMethod('post') && $request->request->get('prendreEnCharge') != null) {

            $commandeToUpdateId = $request->request->get('prendreEnCharge');
            $commandeToUpdate = $repositoryCommande->find($commandeToUpdateId);

            $commandeToUpdate->setFKLI($livreur);
        
            $statusPrisEnCharge = $repositoryStatus->find(3);

            $status = new Possede();
            $status->setFKST($statusPrisEnCharge);
            $status->setFKCO($commandeToUpdate);
            $status->setPODate(new \DateTime('NOW'));

        
            
            $entityManager->persist($commandeToUpdate);
            $entityManager->persist($status);
            $entityManager->flush();

        }

        if ($request->isMethod('post') && $request->request->get('commandeRecupere') != null) {

            $commandeToUpdateId = $request->request->get('commandeRecupere');
            $commandeToUpdate = $repositoryCommande->find($commandeToUpdateId);

            $statusEnCoursDeLivraison = $repositoryStatus->find(6);

            $status = new Possede();
            $status->setFKST($statusEnCoursDeLivraison);
            $status->setFKCO($commandeToUpdate);
            $status->setPODate(new \DateTime('NOW'));

        
            
            $entityManager->persist($commandeToUpdate);
            $entityManager->persist($status);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_livreur');

        }

        if ($request->isMethod('post') && $request->request->get('commandeLivre') != null) {

            $commandeToUpdateId = $request->request->get('commandeLivre');
            $commandeToUpdate = $repositoryCommande->find($commandeToUpdateId);

            $statusEnCoursDeLivraison = $repositoryStatus->find(7);

            $status = new Possede();
            $status->setFKST($statusEnCoursDeLivraison);
            $status->setFKCO($commandeToUpdate);
            $status->setPODate(new \DateTime('NOW'));

        
            
            $entityManager->persist($commandeToUpdate);
            $entityManager->persist($status);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_livreur');

        }

        return $this->render('dashboard_livreur/index.html.twig', [
            'commandes' => $commandesAttentePrisEnCharge,
            'commandesPreiseEnCharge' => $commandesPrisEnCharge
        ]);
    }
}
