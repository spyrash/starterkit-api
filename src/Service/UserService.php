<?php

namespace App\Service;

use App\DTO\RegisterUserRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function register(RegisterUserRequest $registUserData): User
    {
        $user = new User();

        $user->setEmail($registUserData->email)
        ->setPassword($this->passwordHasher->hashPassword($user, $registUserData->password))
        ->setRoles(['ROLE_USER']);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}