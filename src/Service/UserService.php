<?php

namespace App\Service;

use App\DTO\RegisterUserRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserService
{
    public function __construct(
        private EntityManagerInterface      $em,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface       $validator,
    ) {}

    /**
     * @throws \Exception
     */
    public function register(
        ?RegisterUserRequest $registerUserData = null,
        ?User $user = null,
    ): User {
        if (null === $registerUserData && null === $user) {
            throw new \RuntimeException('Cannot create user without data!');
        }

        if (null !== $registerUserData) {
            return $this->registerUserWithDto($registerUserData);
        }
        return $this->persistAndFlush($user);
    }

    /**
     * @throws \Exception
     */
    private function registerUserWithDto(RegisterUserRequest $registerUserData): User
    {
        $user = new User();

        $user->setEmail($registerUserData->email)
            ->setPassword($this->passwordHasher->hashPassword($user, $registerUserData->password))
            ->setRoles(['ROLE_USER']);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            throw new \Exception(json_encode([
                'error' => 'Validation failed',
                'details' => $errorMessages
            ]));
        }
       return $this->persistAndFlush($user);
    }

    private function persistAndFlush(User $user): User
    {
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}