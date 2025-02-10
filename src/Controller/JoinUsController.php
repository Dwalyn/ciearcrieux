<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JoinUsController extends AbstractController
{
    #[Route('/join-us', name: 'joinUs')]
    public function index(): Response
    {
        return $this->render('/joinUs/page.html.twig');
    }
}
