<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MemberController extends AbstractController
{
    #[Route('/members', name: 'membersList')]
    public function list(
        UserRepository $userRepository,
    ): Response {
        return $this->render('/members/list.html.twig', [
            'users' => $userRepository->findBy([], ['lastname' => Order::Ascending->value]),
        ]);
    }
}
