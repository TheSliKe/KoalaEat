<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Compose;
use App\Entity\Plat;
use App\Form\DetailCommandeType;
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

        $repositoryCompose = $entityManager->getRepository(Compose::class);
        $composes = $repositoryCompose->findBy(['FK_CO' => $id]);
        
        $articles = [];
        foreach ($composes as $compose) {
            $repositoryArticle = $entityManager->getRepository(Plat::class);
            $article = $repositoryArticle->findOneBy(['id' =>$compose->getFKPA()]);

            array_push(
                $articles, 
                [
                    "article" => $article,
                    "compose" =>$compose
                ]
            );
        }
        $form1 = $this->createForm(
            DetailCommandeType::class, 
            $commande
        );
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();
        }
        
        return $this->render('detail_commande/index.html.twig', [
            'DetailCommandeType' => $form1->createView(),
            'controller_name' => 'DetailCommandeController',
            'articles' => $articles
        ]);
    }
}