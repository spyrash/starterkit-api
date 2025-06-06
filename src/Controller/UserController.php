<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\RegisterUserRequest;
use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class UserController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function createUser(
        #[MapRequestPayload] RegisterUserRequest $registerUserData,
        UserService                              $userService,
        JWTTokenManagerInterface                  $jwtManager,
    ): Response
    {
        try {
            $user = $userService->register(registerUserData: $registerUserData);
            $token = $jwtManager->create($user);
            return $this->json(
                [
                    'message' => 'User registered successfully',
                    'user' => [
                        'token' => $token,
                        'id' => $user->getId(),
                        'email' => $user->getEmail(),
                    ]
                ], Response::HTTP_CREATED);
        } catch (Throwable $exception) {
            return $this->json($exception->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    // The login route is implemented by default, you do not need to reinvent the wheel
}
