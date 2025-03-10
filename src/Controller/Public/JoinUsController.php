<?php

namespace App\Controller\Public;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JoinUsController extends AbstractController
{
    #[Route('/join-us', name: 'joinUs')]
    public function joinUs(): Response
    {
        return $this->render('/joinUs/page.html.twig');
    }
}
