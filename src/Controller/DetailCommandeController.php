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

        $conn = $entityManager->getConnection();
        $sql = '
                SELECT DISTINCT
                    status.st_libelle as st_libelle, 
                    possede.po_date  as po_date
                FROM commande
                LEFT JOIN compose 
                ON compose.fk_co_id = commande.id
                INNER JOIN possede 
                ON commande.id = possede.fk_co_id
                LEFT JOIN status 
                ON status.id = possede.fk_st_id
                LEFT JOIN plat 
                ON plat.id = compose.fk_pa_id
                WHERE  commande.id = :id
                ORDER BY possede.po_date
            ';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);
        $status = $resultSet->fetchAllAssociative();

        
        return $this->render('detail_commande/index.html.twig', [
            'DetailCommandeType' => $form1->createView(),
            'controller_name' => 'DetailCommandeController',
            'articles' => $articles, 
            'status' => $status
        ]);
    }
}