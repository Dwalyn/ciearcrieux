<?php

namespace App\Controller\Public;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        PostRepository $postRepository,
    ): Response {
        $listPost = $postRepository->findBy([], ['postDate' => Order::Descending->value], 5);

        return $this->render(
            '/home/page.html.twig',
            [
                'listPost' => $listPost,
            ]
        );
    }
}
