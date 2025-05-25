<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\RegisterUserRequest;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function createUser(
        #[MapRequestPayload] RegisterUserRequest $registerUserData,
        UserService                              $userService,
    ): Response
    {
        $user = $userService->register(registUserData: $registerUserData);
        return $this->json(
            [
                'message' => 'User registered successfully',
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                ]
            ], Response::HTTP_CREATED);
    }
}
