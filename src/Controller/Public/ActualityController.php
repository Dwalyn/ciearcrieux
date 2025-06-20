<?php

namespace App\Controller\Public;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ActualityController extends AbstractController
{
    #[Route('/actuality', name: 'actuality')]
    public function list(
        PostRepository $postRepository,
        Request $request,
    ): Response {
        return $this->render(
            '/actuality/page.html.twig',
        );
    }
}
