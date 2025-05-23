<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProvaController extends AbstractController
{
    #[Route('/prova')]
    public function index(): Response
    {
        return $this->render('prova/index.html.twig');
    }
}
