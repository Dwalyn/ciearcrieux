<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FindUsController extends AbstractController
{
    #[Route('/find-us', name: 'findUs')]
    public function findUs(): Response
    {
        return $this->render('/findUs/page.html.twig');
    }
}
