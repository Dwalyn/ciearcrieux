<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LicenseControlller extends AbstractController
{
    #[Route('/license', name: 'license')]
    public function index(): Response
    {
        return $this->render('/license/page.html.twig');
    }
}
