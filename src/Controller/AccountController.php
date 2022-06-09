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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{

    #[Route('/register', name: 'register')]
    public function index(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface  $userAuthenticator,
        EntityManagerInterface $entityManager,
    ): Response
    {
         
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


    #[Route('/mon-compte', name:'compte')]
    public function myAccount()
    {

        $user = $this->getUser();

        return $this->render('account/account.html.twig', [
            'controller_name' => 'AccountController',
            'user'            => $user
        ]);
    }


    #[Route('/login', name:'login')]
    public function logIn(AuthenticationUtils $authenticationUtils)
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/login.html.twig', [
            "last_username" => $lastUsername,
            "error"         => $error,
        ]);
    }

    #[Route("/logout", name:"logout")]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


}
