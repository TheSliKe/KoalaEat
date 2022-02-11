<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Livreur;
use App\Entity\Restaurateur;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();



            // do anything else you need here, like send an email

            $accountType = $form->get('accountType')->getData();

            if ($accountType == 1) {

                $user->setRoles(array("client"));

                $client = new Client();
                $client->setCLMail($form->get('email')->getData());
                $client->setFKUS($user);

                $entityManager->persist($client);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_login');
            } elseif ($accountType == 2) {

                $user->setRoles(array("restaurateur"));

                $restaurateur = new Restaurateur();
                $restaurateur->setRESMail($form->get('email')->getData());
                $restaurateur->setFKUS($user);
                
                $entityManager->persist($restaurateur);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_login');
            } elseif ($accountType == 3) {

                $user->setRoles(array("livreur"));

                $livreur = new Livreur();
                $livreur->setLIMail($form->get('email')->getData());
                $livreur->setFKUS($user);
                
                $entityManager->persist($livreur);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_login');
            } else {
                return $this->redirectToRoute('app_register');
            }

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'backgroundImg' => "login"
        ]);
    }
}