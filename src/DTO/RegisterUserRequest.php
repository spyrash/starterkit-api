<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
class RegisterUserRequest
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6)]
    public string $password;
}