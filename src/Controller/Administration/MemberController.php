<?php

namespace App\Controller\Administration;

use App\Enum\RoleEnum;
use App\Form\Datas\User\AddUserFormData;
use App\Form\Type\User\AddUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_')]
class MemberController extends AbstractController
{
    #[Route('/members', name: 'membersList')]
    public function list(): Response
    {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        return $this->render('/administration/members/list.html.twig');
    }

    #[Route('/members/add', name: 'membersAdd')]
    public function add(
        Request $request,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);
        $dataForm = new AddUserFormData();

        $form = $this->createForm(AddUserType::class, $dataForm);
        $form->handleRequest($request);

        return $this->render('/administration/members/add.html.twig', [
            'form' => $form,
        ]);
    }
}
