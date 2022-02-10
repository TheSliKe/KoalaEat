<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livreur;
use App\Entity\Vehicule;
use App\Form\ProfilLivreurFormType;
use App\Form\VehiculeFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class ProfilLivreurController extends AbstractController
{
    private $security;
    public function __construct(Security $security){
        $this->security = $security;
    }
    #[Route('/profil/livreur', name: 'profil_livreur')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser()->getId();
        //$idUser = $this->security->getUser()->getId();
        $repository = $entityManager->getRepository(Livreur::class);
        $livreur = $repository->findOneBy(['FK_US' => $user]);
        $vehicule = new Vehicule();
        $form = $this->createForm(ProfilLivreurFormType::class, $livreur);
        $form->handleRequest($request);
        $form1 = $this->createForm(VehiculeFormType::class);
        $form1->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($livreur);
            $entityManager->flush();
        }
        if($form1->isSubmitted() && $form1->isValid()){
            $vehicule = $form1->getData();
            $vehicule->setFKLI($livreur);
            $entityManager->persist($vehicule);
            $entityManager->flush();
        }
        return $this->render('profil_livreur/index.html.twig', [
            'ProfilLivreurForm'=> $form->createView(),
            'VehiculeForm' => $form1->createView(),
            'user'=> $user,
            'livreur' => $livreur
        ]);
    }
}
