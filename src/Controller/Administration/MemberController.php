<?php

namespace App\Controller\Administration;

use App\Form\Datas\User\AddUserFormData;
use App\Form\Type\User\AddUserType;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MemberController extends AbstractController
{
    #[Route('/members', name: 'membersList')]
    public function list(
        UserRepository $userRepository,
    ): Response {
        return $this->render('/members/list.html.twig', [
            'users' => $userRepository->findBy([], ['lastname' => Order::Descending->value]),
        ]);
    }

    #[Route('/members/add', name: 'membersAdd')]
    public function add(
        Request $request,
    ): Response {
        $dataForm = new AddUserFormData();

        $form = $this->createForm(AddUserType::class, $dataForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Form ok');
        }

        return $this->render('/members/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
