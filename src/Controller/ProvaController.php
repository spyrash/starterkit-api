<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProvaController extends AbstractController
{
    #[Route('/debug/create-user', name: 'debug_create_user', methods: ['POST'])]
    public function createUser(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $hashedPassword = $passwordHasher->hashPassword($user, 'test1234');
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'User created', 'email' => $user->getEmail()], Response::HTTP_CREATED);
    }

    #[Route('/api/user/me', name: 'debug_create_user', methods: ['GET'])]
    public function lol(): JsonResponse
    {
        return $this->json(['message' => 'Hello I am here and logged, the JWT WORKS!'], Response::HTTP_CREATED);
    }


    /** step by step:
     * the db is in app.public of postman
     * it seems like user table is saved and there
     * if no user use debug/create-user
     * u have to do a post in api/login to get the token (plain password is ok)
     * then call any route with the header: authorization: Bearer <token> where <token> is your token from the api/login like 1aasd355assff...
     */
}