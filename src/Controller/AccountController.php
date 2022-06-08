<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'compte')]
    public function index(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface  $userAuthenticator,
        EntityManagerInterface $entityManager,
    ): Response
    {

        
        //Si user pas connecté actuellement
        if(!$this->getUser()){
            
            $user = new User;
            $registrationForm = $this->createForm(RegistrationType::class, $user);
            $registrationForm->handleRequest($request);

            if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
                    
            // encodage du mot de passe
            $user->setPassword($userPasswordHasher->hashPassword($user,$registrationForm->get('password')->getData()));

            $entityManager->persist($user);
            $entityManager->flush();

            }

            
            return $this->render('account/register.html.twig', [
                'registrationForm' => $registrationForm->createView(),
            ]);

        }

        
        else{
            return $this->render('account/account.html.twig', [
                'controller_name' => 'AccountController',
            ]);
        }

    }




}
