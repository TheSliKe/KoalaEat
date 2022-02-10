<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Compose;
use App\Entity\Plat;
use App\Entity\Possede;
use App\Form\ProfilClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfilClientController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/profil/client', name: 'profil_client')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {  

        $user = $this->security->getUser();

        $repository = $entityManager->getRepository(Client::class);
        $client = $repository->findOneBy(['FK_US' => $user]);

        $form1 = $this->createForm(ProfilClientType::class, $client);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();
        }
        return $this->render('profil_client/index.html.twig', [
            'ProfilClientForm' => $form1->createView(), 
            'user' => $user,
            'client' => $client
        ]);

    }

    #[Route('/client/commandeEnCours', name: 'commande_en_cours_client')]
    public function commandeEnCours(EntityManagerInterface $entityManager) : Response
    {
        $user = $this->security->getUser();
        $repoClient = $entityManager->getRepository(Client::class);
        $repoPossede = $entityManager->getRepository(Possede::class);
        $repoCommande = $entityManager->getRepository(Commande::class);

        $client = $repoClient->findOneBy(['FK_US' => $user]);
        $commandes = $repoCommande->findBy(['FK_CL' => $client]);
        $possedes = $repoPossede->findBy(['FK_CO' => $commandes]);

        return $this->render('commandes_client/commande_en_cours.html.twig', [
            'possedes' => $possedes
        ]);
    }

    #[Route('/client/historiqueCommande', name: 'historique_commande')]
    public function historiqueCommande(EntityManagerInterface $entityManager) : Response
    {
        $user = $this->security->getUser();
        $repoClient = $entityManager->getRepository(Client::class);
        $repoPossede = $entityManager->getRepository(Possede::class);
        $repoCommande = $entityManager->getRepository(Commande::class);

        $client = $repoClient->findOneBy(['FK_US' => $user]);
        $commandes = $repoCommande->findBy(['FK_CL' => $client]);
        $possedes = $repoPossede->findBy(['FK_CO' => $commandes]);

        
        return $this->render('commandes_client/historique_commandes.html.twig', [
            'possedes' => $possedes,
            'commandes' => $commandes
        ]);
    }

    #[Route('/client/detailsCommande', name: 'details_commande', methods : ['POST'])]

    public function detailsCommande(Request $request, EntityManagerInterface $entityManager) : Response
    {

        $repoCommande = $entityManager->getRepository(Commande::class);
        $repoCompose = $entityManager->getRepository(Compose::class);
        $repoPlat = $entityManager->getRepository(Plat::class);


        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $info= [];
            $idCommande = $_POST['id'];
            $commande = $repoCommande->find($idCommande);
            $composes = $repoCompose->findBy(['FK_CO' => $commande]);
            foreach ($composes as $compose) {
                $plat = $compose->getFKPA();

                array_push($info, ['Libelle' => $plat->getPALibelle()]);
            }
            // $plats = $repoCompose->getPlats();
            // $jsonData = array();
            $jsonData = $info;  
            return new JsonResponse($jsonData); 
         } else { 
            return $this->render('commandes_client/historique_commandes.html.twig'); 
         }
    }
}
