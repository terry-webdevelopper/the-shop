<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // on crée l'objet user dans une variable
        $user = new User();
        // on crée le formulaire, la classe du formulaire et les données de l'objet user
        // est ce que le this représente le formulaire? 
        $form = $this->createForm(RegisterType::class, $user);
        // le formulaire peut écouter la requête d'un utilisateur
        $form->handleRequest($request);
        // si soumis et si valide, enregistre toutes les données dans $user
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $userPasswordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
        return $this->render('register/index.html.twig', [
            // on crée la vue du formulaire qui a déjà été crée
            'form' => $form->createView()
        ]);
    }
}
