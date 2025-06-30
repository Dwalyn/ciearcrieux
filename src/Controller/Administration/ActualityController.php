<?php

namespace App\Controller\Administration;

use App\Enum\RoleEnum;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_')]
class ActualityController extends AbstractController
{
    #[Route('/posts', name: 'postsList')]
    public function list(
        PostRepository $postRepository,
    ): Response
    {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        $listPost = $postRepository->findBy([], ['postDate' => Order::Descending->value]);

        return $this->render('/administration/post/list.html.twig',[
            'listPost' => $listPost,
        ]);
    }
}
