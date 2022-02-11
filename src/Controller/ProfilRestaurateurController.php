<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Restaurateur;
use App\Entity\Restaurant;
use App\Entity\HoraireRestaurant;
use App\Entity\Plat;
use App\Entity\Semaine;
use App\Form\ProfilRestaurateurFormType;
use App\Form\CreerRestaurantType;
use App\Form\RestaurantHoraireType;
use DateTime;
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
        $user_id = $this->getUser();

        $repository = $entityManager->getRepository(Restaurateur::class);
        $restaurateur = $repository->findOneBy(['FK_US' => $user_id]);

        $form1 = $this->createForm(ProfilRestaurateurFormType::class, $restaurateur);
        $form1->handleRequest($request);
        
        $listeRestaurant = $restaurateur->getRestaurants();

        
        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager->persist($restaurateur);
            $entityManager->flush();
        }

        if ($request->isMethod('post') && $request->request->get('delete') != null) {

            $restaurantToRemoveId = $request->request->get('delete');

            $repositoryRestaurant = $entityManager->getRepository(Restaurant::class);
            $repositoryPlat = $entityManager->getRepository(Plat::class);
            $repositoryHoraire = $entityManager->getRepository(HoraireRestaurant::class);

            $horairesToRemove = $repositoryHoraire->findBy(['FK_RE' => $restaurantToRemoveId]);
            $platsToRemove = $repositoryPlat->findBy(['FK_RE' => $restaurantToRemoveId]);
            $restaurantToRemove = $repositoryRestaurant->findOneBy(['id' => $restaurantToRemoveId]);

            $categorieToRemoves = $restaurantToRemove->getCategories();

            foreach ($categorieToRemoves as $key => $value) {
                $restaurantToRemove->removeCategory($value);
            }
            foreach ($horairesToRemove as $key => $value) {
                $entityManager->remove($value);
            }
            foreach ($platsToRemove as $key => $value) {
                $entityManager->remove($value);
            }

            $entityManager->remove($restaurantToRemove);
            $entityManager->flush();
        }

        return $this->render('profil_restaurateur/index.html.twig', [
            'ProfilRestaurateurForm' => $form1->createView(), 
            'listeRestaurant' => $listeRestaurant,
            'backgroundImg' => "restaurateur"
        ]);
    }

    #[Route('/profil/restaurateur/restaurant/add/p1', name: 'edition_restaurant_first')]
    public function addRestaurantP1(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $user_id = $this->getUser();
        $restaurant = new Restaurant();

        $form = $this->createForm(CreerRestaurantType::class, $restaurant);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $repository = $entityManager->getRepository(Restaurateur::class);
            $restaurateur = $repository->findOneBy(['FK_US' => $user_id]);

            $restaurant->setFKRESId($restaurateur);
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('edition_restaurant_second', ['rest' => $restaurant->getId()]);
        }

        return $this->render('edition_restaurant/restaurant.html.twig', [                
            'CreerRestaurantType' => $form->createView(),
            'backgroundImg' => "restaurateur"
        ]);
    }

    #[Route('/profil/restaurateur/restaurant/add/p2', name: 'edition_restaurant_second')]
    public function addRestaurantP2(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        if ($request->isMethod('post')) {
            
            $restoId = $request->query->get('rest');
            $repositoryRestaurant = $entityManager->getRepository(Restaurant::class);
            $restaurant = $repositoryRestaurant->findOneBy(['id' => $restoId]);

            $repositorySemaine = $entityManager->getRepository(Semaine::class);
            $lundi = $repositorySemaine->findOneBy(['id' => 1]);
            $mardi = $repositorySemaine->findOneBy(['id' => 2]);
            $mercredi = $repositorySemaine->findOneBy(['id' => 3]);
            $jeudi = $repositorySemaine->findOneBy(['id' => 4]);
            $vendredi = $repositorySemaine->findOneBy(['id' => 5]);
            $samedi = $repositorySemaine->findOneBy(['id' => 6]);
            $dimanche = $repositorySemaine->findOneBy(['id' => 7]);

            $horaireRestaurantlundi = new HoraireRestaurant();
            $horaireRestaurantmardi = new HoraireRestaurant();
            $horaireRestaurantmercredi = new HoraireRestaurant();
            $horaireRestaurantjeudi = new HoraireRestaurant();
            $horaireRestaurantvendredi = new HoraireRestaurant();
            $horaireRestaurantsamedi = new HoraireRestaurant();
            $horaireRestaurantdimanche = new HoraireRestaurant();

            $lundiStartMidi = $request->request->get('lundi-start-midi');
            $lundiStopMidi = $request->request->get('lundi-stop-midi');
            $lundiStartSoir = $request->request->get('lundi-start-soir');
            $lundiStopSoir = $request->request->get('lundi-stop-soir');

            $mardiStartMidi = $request->request->get('mardi-start-midi');
            $mardiStopMidi = $request->request->get('mardi-stop-midi');
            $mardiStartSoir = $request->request->get('mardi-start-soir');
            $mardiStopSoir = $request->request->get('mardi-stop-soir');

            $mercrediStartMidi = $request->request->get('mercredi-start-midi');
            $mercrediStopMidi = $request->request->get('mercredi-stop-midi');
            $mercrediStartSoir = $request->request->get('mercredi-start-soir');
            $mercrediStopSoir = $request->request->get('mercredi-stop-soir');

            $jeudiStartMidi = $request->request->get('jeudi-start-midi');
            $jeudiStopMidi = $request->request->get('jeudi-stop-midi');
            $jeudiStartSoir = $request->request->get('jeudi-start-soir');
            $jeudiStopSoir = $request->request->get('jeudi-stop-soir');

            $vendrediStartMidi = $request->request->get('vendredi-start-midi');
            $vendrediStopMidi = $request->request->get('vendredi-stop-midi');
            $vendrediStartSoir = $request->request->get('vendredi-start-soir');
            $vendrediStopSoir = $request->request->get('vendredi-stop-soir');

            $samediStartMidi = $request->request->get('samedi-start-midi');
            $samediStopMidi = $request->request->get('samedi-stop-midi');
            $samediStartSoir = $request->request->get('samedi-start-soir');
            $samediStopSoir = $request->request->get('samedi-stop-soir');

            $dimancheStartMidi = $request->request->get('dimanche-start-midi');
            $dimancheStopMidi = $request->request->get('dimanche-stop-midi');
            $dimancheStartSoir = $request->request->get('dimanche-start-soir');
            $dimancheStopSoir = $request->request->get('dimanche-stop-soir');

            $fermerLundiMidi = $request->request->get('closeMidiLundi');
            $fermerLundiSoir = $request->request->get('closeSoirLundi');
            $fermerMardiMidi = $request->request->get('closeMidiMardi');
            $fermerMardiSoir = $request->request->get('closeSoirMardi');
            $fermerMercrediMidi = $request->request->get('closeMidiMercredi');
            $fermerMercrediSoir = $request->request->get('closeSoirMercredi');
            $fermerJeudiMidi = $request->request->get('closeMidiJeudi');
            $fermerJeudiSoir = $request->request->get('closeSoirJeudi');
            $fermerVendrediMidi = $request->request->get('closeMidiVendredi');
            $fermerVendrediSoir = $request->request->get('closeSoirVendredi');
            $fermerSamediMidi = $request->request->get('closeMidiSamedi');
            $fermerSamediSoir = $request->request->get('closeSoirSamedi');
            $fermerDimancheMidi = $request->request->get('closeMidiDimanche');
            $fermerDimancheSoir = $request->request->get('closeSoirDimanche');
           

            $horaireRestaurantlundi->setFKRE($restaurant);
            $horaireRestaurantlundi->setFKSEM($lundi);
            if ($fermerLundiMidi == "true" || $fermerLundiSoir == "true"){
                if ($fermerLundiMidi == "true"){
                    $horaireRestaurantlundi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantlundi->setHoraireFinMidi("fermé");
                }
                if ($fermerLundiSoir == "true"){
                    $horaireRestaurantlundi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantlundi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantlundi->setHoraireDebutMidi($lundiStartMidi);
                $horaireRestaurantlundi->setHoraireFinMidi($lundiStopMidi);
                $horaireRestaurantlundi->setHoraireDebutSoir($lundiStartSoir);
                $horaireRestaurantlundi->setHoraireFinSoir($lundiStopSoir);
            }

            $entityManager->persist($horaireRestaurantlundi);

            $horaireRestaurantmardi->setFKRE($restaurant);
            $horaireRestaurantmardi->setFKSEM($mardi);
            if ($fermerMardiMidi == "true" || $fermerMardiSoir == "true"){
                if ($fermerMardiMidi == "true"){
                    $horaireRestaurantmardi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantmardi->setHoraireFinMidi("fermé");
                }
                if ($fermerMardiSoir == "true"){
                    $horaireRestaurantmardi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantmardi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantmardi->setHoraireDebutMidi($mardiStartMidi);
                $horaireRestaurantmardi->setHoraireFinMidi($mardiStopMidi);
                $horaireRestaurantmardi->setHoraireDebutSoir($mardiStartSoir);
                $horaireRestaurantmardi->setHoraireFinSoir($mardiStopSoir);
            }
            $entityManager->persist($horaireRestaurantmardi);

            $horaireRestaurantmercredi->setFKRE($restaurant);
            $horaireRestaurantmercredi->setFKSEM($mercredi);
            if ($fermerMercrediMidi == "true" || $fermerMercrediSoir == "true"){
                if ($fermerMercrediMidi == "true"){
                    $horaireRestaurantmercredi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantmercredi->setHoraireFinMidi("fermé");
                }
                if ($fermerMercrediSoir == "true"){
                    $horaireRestaurantmercredi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantmercredi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantmercredi->setHoraireDebutMidi($mercrediStartMidi);
                $horaireRestaurantmercredi->setHoraireFinMidi($mercrediStopMidi);
                $horaireRestaurantmercredi->setHoraireDebutSoir($mercrediStartSoir);
                $horaireRestaurantmercredi->setHoraireFinSoir($mercrediStopSoir);
            }

            $entityManager->persist($horaireRestaurantmercredi);

            $horaireRestaurantjeudi->setFKRE($restaurant);
            $horaireRestaurantjeudi->setFKSEM($jeudi);
            if ($fermerJeudiMidi == "true" || $fermerJeudiSoir == "true"){
                if ($fermerJeudiMidi == "true"){
                    $horaireRestaurantjeudi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantjeudi->setHoraireFinMidi("fermé");
                }
                if ($fermerJeudiSoir == "true"){
                    $horaireRestaurantjeudi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantjeudi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantjeudi->setHoraireDebutMidi($jeudiStartMidi);
                $horaireRestaurantjeudi->setHoraireFinMidi($jeudiStopMidi);
                $horaireRestaurantjeudi->setHoraireDebutSoir($jeudiStartSoir);
                $horaireRestaurantjeudi->setHoraireFinSoir($jeudiStopSoir);
            }

            $entityManager->persist($horaireRestaurantjeudi);

            $horaireRestaurantvendredi->setFKRE($restaurant);
            $horaireRestaurantvendredi->setFKSEM($vendredi);
            if ($fermerVendrediMidi == "true" || $fermerVendrediSoir == "true"){
                if ($fermerVendrediMidi == "true"){
                    $horaireRestaurantvendredi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantvendredi->setHoraireFinMidi("fermé");
                }
                if ($fermerVendrediSoir == "true"){
                    $horaireRestaurantvendredi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantvendredi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantvendredi->setHoraireDebutMidi($vendrediStartMidi);
                $horaireRestaurantvendredi->setHoraireFinMidi($vendrediStopMidi);
                $horaireRestaurantvendredi->setHoraireDebutSoir($vendrediStartSoir);
                $horaireRestaurantvendredi->setHoraireFinSoir($vendrediStopSoir);
            }

            $entityManager->persist($horaireRestaurantvendredi);

            $horaireRestaurantsamedi->setFKRE($restaurant);
            $horaireRestaurantsamedi->setFKSEM($samedi);
            if ($fermerSamediMidi == "true" || $fermerSamediSoir == "true"){
                if ($fermerSamediMidi == "true"){
                    $horaireRestaurantsamedi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantsamedi->setHoraireFinMidi("fermé");
                }
                if ($fermerSamediSoir == "true"){
                    $horaireRestaurantsamedi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantsamedi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantsamedi->setHoraireDebutMidi($samediStartMidi);
                $horaireRestaurantsamedi->setHoraireFinMidi($samediStopMidi);
                $horaireRestaurantsamedi->setHoraireDebutSoir($samediStartSoir);
                $horaireRestaurantsamedi->setHoraireFinSoir($samediStopSoir);
            }
            $entityManager->persist($horaireRestaurantsamedi);

            $horaireRestaurantdimanche->setFKRE($restaurant);
            $horaireRestaurantdimanche->setFKSEM($dimanche);
            if ($fermerDimancheMidi == "true" || $fermerDimancheSoir == "true"){
                if ($fermerDimancheMidi == "true"){
                    $horaireRestaurantdimanche->setHoraireDebutMidi("fermé");
                    $horaireRestaurantdimanche->setHoraireFinMidi("fermé");
                }
                if ($fermerDimancheSoir == "true"){
                    $horaireRestaurantdimanche->setHoraireDebutSoir("fermé");
                    $horaireRestaurantdimanche->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantdimanche->setHoraireDebutMidi($dimancheStartMidi);
                $horaireRestaurantdimanche->setHoraireFinMidi($dimancheStopMidi);
                $horaireRestaurantdimanche->setHoraireDebutSoir($dimancheStartSoir);
                $horaireRestaurantdimanche->setHoraireFinSoir($dimancheStopSoir);
            }
            
            $entityManager->persist($horaireRestaurantdimanche);
            $entityManager->flush();

            return $this->redirectToRoute('profil_restaurateur');

        }
        
        return $this->render('edition_restaurant/horaire.html.twig', [
            'edit'=> false,
            'backgroundImg' => "restaurateur"
        ]);
    }

    #[Route('/profil/restaurateur/restaurant/modify/p1', name: 'modify_restaurant_first')]
    public function modifyRestaurantP1(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $restoId = $request->query->get('rest');
        $repositoryRestaurant = $entityManager->getRepository(Restaurant::class);
        $restaurant = $repositoryRestaurant->findOneBy(['id' => $restoId]);

        $form = $this->createForm(CreerRestaurantType::class, $restaurant);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('modify_restaurant_second', ['rest' => $restaurant->getId()]);
        }

        return $this->render('edition_restaurant/restaurant.html.twig', [                
            'CreerRestaurantType' => $form->createView(),
            'backgroundImg' => "restaurateur"
        ]);
    }

    #[Route('/profil/restaurateur/restaurant/modify/p2', name: 'modify_restaurant_second')]
    public function modifyRestaurantP2(Request $request, EntityManagerInterface $entityManager): Response
    {

        $restoId = $request->query->get('rest');
        $repositoryHoraire = $entityManager->getRepository(HoraireRestaurant::class);

        $horaireRestaurantlundi = $repositoryHoraire->findOneBy(['FK_RE' => $restoId, 'FK_SEM' => 1]);
        $horaireRestaurantmardi = $repositoryHoraire->findOneBy(['FK_RE' => $restoId, 'FK_SEM' => 2]);
        $horaireRestaurantmercredi = $repositoryHoraire->findOneBy(['FK_RE' => $restoId, 'FK_SEM' => 3]);
        $horaireRestaurantjeudi = $repositoryHoraire->findOneBy(['FK_RE' => $restoId, 'FK_SEM' => 4]);
        $horaireRestaurantvendredi = $repositoryHoraire->findOneBy(['FK_RE' => $restoId, 'FK_SEM' => 5]);
        $horaireRestaurantsamedi = $repositoryHoraire->findOneBy(['FK_RE' => $restoId, 'FK_SEM' => 6]);
        $horaireRestaurantdimanche = $repositoryHoraire->findOneBy(['FK_RE' => $restoId, 'FK_SEM' => 7]);
        
        if ($request->isMethod('post')) {

            $lundiStartMidi = $request->request->get('lundi-start-midi');
            $lundiStopMidi = $request->request->get('lundi-stop-midi');
            $lundiStartSoir = $request->request->get('lundi-start-soir');
            $lundiStopSoir = $request->request->get('lundi-stop-soir');

            $mardiStartMidi = $request->request->get('mardi-start-midi');
            $mardiStopMidi = $request->request->get('mardi-stop-midi');
            $mardiStartSoir = $request->request->get('mardi-start-soir');
            $mardiStopSoir = $request->request->get('mardi-stop-soir');

            $mercrediStartMidi = $request->request->get('mercredi-start-midi');
            $mercrediStopMidi = $request->request->get('mercredi-stop-midi');
            $mercrediStartSoir = $request->request->get('mercredi-start-soir');
            $mercrediStopSoir = $request->request->get('mercredi-stop-soir');

            $jeudiStartMidi = $request->request->get('jeudi-start-midi');
            $jeudiStopMidi = $request->request->get('jeudi-stop-midi');
            $jeudiStartSoir = $request->request->get('jeudi-start-soir');
            $jeudiStopSoir = $request->request->get('jeudi-stop-soir');

            $vendrediStartMidi = $request->request->get('vendredi-start-midi');
            $vendrediStopMidi = $request->request->get('vendredi-stop-midi');
            $vendrediStartSoir = $request->request->get('vendredi-start-soir');
            $vendrediStopSoir = $request->request->get('vendredi-stop-soir');

            $samediStartMidi = $request->request->get('samedi-start-midi');
            $samediStopMidi = $request->request->get('samedi-stop-midi');
            $samediStartSoir = $request->request->get('samedi-start-soir');
            $samediStopSoir = $request->request->get('samedi-stop-soir');

            $dimancheStartMidi = $request->request->get('dimanche-start-midi');
            $dimancheStopMidi = $request->request->get('dimanche-stop-midi');
            $dimancheStartSoir = $request->request->get('dimanche-start-soir');
            $dimancheStopSoir = $request->request->get('dimanche-stop-soir');

            $fermerLundiMidi = $request->request->get('closeMidiLundi');
            $fermerLundiSoir = $request->request->get('closeSoirLundi');
            $fermerMardiMidi = $request->request->get('closeMidiMardi');
            $fermerMardiSoir = $request->request->get('closeSoirMardi');
            $fermerMercrediMidi = $request->request->get('closeMidiMercredi');
            $fermerMercrediSoir = $request->request->get('closeSoirMercredi');
            $fermerJeudiMidi = $request->request->get('closeMidiJeudi');
            $fermerJeudiSoir = $request->request->get('closeSoirJeudi');
            $fermerVendrediMidi = $request->request->get('closeMidiVendredi');
            $fermerVendrediSoir = $request->request->get('closeSoirVendredi');
            $fermerSamediMidi = $request->request->get('closeMidiSamedi');
            $fermerSamediSoir = $request->request->get('closeSoirSamedi');
            $fermerDimancheMidi = $request->request->get('closeMidiDimanche');
            $fermerDimancheSoir = $request->request->get('closeSoirDimanche');

            if ($fermerLundiMidi == "true" || $fermerLundiSoir == "true"){
                if ($fermerLundiMidi == "true"){
                    $horaireRestaurantlundi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantlundi->setHoraireFinMidi("fermé");
                }
                if ($fermerLundiSoir == "true"){
                    $horaireRestaurantlundi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantlundi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantlundi->setHoraireDebutMidi($lundiStartMidi);
                $horaireRestaurantlundi->setHoraireFinMidi($lundiStopMidi);
                $horaireRestaurantlundi->setHoraireDebutSoir($lundiStartSoir);
                $horaireRestaurantlundi->setHoraireFinSoir($lundiStopSoir);
            }
            $entityManager->persist($horaireRestaurantlundi);

            if ($fermerMardiMidi == "true" || $fermerMardiSoir == "true"){
                if ($fermerMardiMidi == "true"){
                    $horaireRestaurantmardi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantmardi->setHoraireFinMidi("fermé");
                }
                if ($fermerMardiSoir == "true"){
                    $horaireRestaurantmardi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantmardi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantmardi->setHoraireDebutMidi($mardiStartMidi);
                $horaireRestaurantmardi->setHoraireFinMidi($mardiStopMidi);
                $horaireRestaurantmardi->setHoraireDebutSoir($mardiStartSoir);
                $horaireRestaurantmardi->setHoraireFinSoir($mardiStopSoir);
            }

            $entityManager->persist($horaireRestaurantmardi);

            if ($fermerMercrediMidi == "true" || $fermerMercrediSoir == "true"){
                if ($fermerMercrediMidi == "true"){
                    $horaireRestaurantmercredi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantmercredi->setHoraireFinMidi("fermé");
                }
                if ($fermerMercrediSoir == "true"){
                    $horaireRestaurantmercredi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantmercredi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantmercredi->setHoraireDebutMidi($mercrediStartMidi);
                $horaireRestaurantmercredi->setHoraireFinMidi($mercrediStopMidi);
                $horaireRestaurantmercredi->setHoraireDebutSoir($mercrediStartSoir);
                $horaireRestaurantmercredi->setHoraireFinSoir($mercrediStopSoir);
            }

            $entityManager->persist($horaireRestaurantmercredi);

            if ($fermerJeudiMidi == "true" || $fermerJeudiSoir == "true"){
                if ($fermerJeudiMidi == "true"){
                    $horaireRestaurantjeudi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantjeudi->setHoraireFinMidi("fermé");
                }
                if ($fermerJeudiSoir == "true"){
                    $horaireRestaurantjeudi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantjeudi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantjeudi->setHoraireDebutMidi($jeudiStartMidi);
                $horaireRestaurantjeudi->setHoraireFinMidi($jeudiStopMidi);
                $horaireRestaurantjeudi->setHoraireDebutSoir($jeudiStartSoir);
                $horaireRestaurantjeudi->setHoraireFinSoir($jeudiStopSoir);
            }

            $entityManager->persist($horaireRestaurantjeudi);
            
            if ($fermerVendrediMidi == "true" || $fermerVendrediSoir == "true"){
                if ($fermerVendrediMidi == "true"){
                    $horaireRestaurantvendredi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantvendredi->setHoraireFinMidi("fermé");
                }
                if ($fermerVendrediSoir == "true"){
                    $horaireRestaurantvendredi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantvendredi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantvendredi->setHoraireDebutMidi($vendrediStartMidi);
                $horaireRestaurantvendredi->setHoraireFinMidi($vendrediStopMidi);
                $horaireRestaurantvendredi->setHoraireDebutSoir($vendrediStartSoir);
                $horaireRestaurantvendredi->setHoraireFinSoir($vendrediStopSoir);
            }

            $entityManager->persist($horaireRestaurantvendredi);

            if ($fermerSamediMidi == "true" || $fermerSamediSoir == "true"){
                if ($fermerSamediMidi == "true"){
                    $horaireRestaurantsamedi->setHoraireDebutMidi("fermé");
                    $horaireRestaurantsamedi->setHoraireFinMidi("fermé");
                }
                if ($fermerSamediSoir == "true"){
                    $horaireRestaurantsamedi->setHoraireDebutSoir("fermé");
                    $horaireRestaurantsamedi->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantsamedi->setHoraireDebutMidi($samediStartMidi);
                $horaireRestaurantsamedi->setHoraireFinMidi($samediStopMidi);
                $horaireRestaurantsamedi->setHoraireDebutSoir($samediStartSoir);
                $horaireRestaurantsamedi->setHoraireFinSoir($samediStopSoir);
            }
            
            $entityManager->persist($horaireRestaurantsamedi);

            if ($fermerDimancheMidi == "true" || $fermerDimancheSoir == "true"){
                if ($fermerDimancheMidi == "true"){
                    $horaireRestaurantdimanche->setHoraireDebutMidi("fermé");
                    $horaireRestaurantdimanche->setHoraireFinMidi("fermé");
                }
                if ($fermerDimancheSoir == "true"){
                    $horaireRestaurantdimanche->setHoraireDebutSoir("fermé");
                    $horaireRestaurantdimanche->setHoraireFinSoir("fermé");
                }
            } else {
                $horaireRestaurantdimanche->setHoraireDebutMidi($dimancheStartMidi);
                $horaireRestaurantdimanche->setHoraireFinMidi($dimancheStopMidi);
                $horaireRestaurantdimanche->setHoraireDebutSoir($dimancheStartSoir);
                $horaireRestaurantdimanche->setHoraireFinSoir($dimancheStopSoir);
            }

            $entityManager->persist($horaireRestaurantdimanche);

            $entityManager->flush();

            return $this->redirectToRoute('profil_restaurateur');

        }
        
        return $this->render('edition_restaurant/horaire.html.twig', [
            'horaireLundi' => $horaireRestaurantlundi,
            'horaireMardi' => $horaireRestaurantmardi,
            'horaireMercredi' => $horaireRestaurantmercredi,
            'horaireJeudi' => $horaireRestaurantjeudi,
            'horaireVendredi' => $horaireRestaurantvendredi,
            'horaireSamedi' => $horaireRestaurantsamedi,
            'horaireDimanche' => $horaireRestaurantdimanche,
            'edit'=> true,
            'backgroundImg' => "restaurateur"
        ]);
    }

}