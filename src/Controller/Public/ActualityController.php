<?php

namespace App\Controller\Public;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ActualityController extends AbstractController
{
    #[Route('/actuality', name: 'actuality')]
    public function list(
        Request $request,
    ): Response {
        return $this->render(
            '/actuality/page.html.twig',
            [
                'page' => $request->query->getInt('page', 1),
            ]
        );
    }

    #[Route('/actuality/{id}', name: 'actuality_show')]
    public function show(
        Post $post,
    ): Response {
        return $this->render(
            '/actuality/show.html.twig',
            [
                'post' => $post,
            ]
        );
    }
}
