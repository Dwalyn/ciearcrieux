<?php

namespace App\Controller\Administration;

use App\Command\CommandBusInterface;
use App\Command\User\AddUserCommand;
use App\Enum\RoleEnum;
use App\Form\Datas\User\AddUserFormData;
use App\Form\Type\User\AddUserType;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_')]
class MemberController extends AbstractController
{
    public function __construct(
        protected readonly CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/members', name: 'membersList')]
    public function list(
        UserRepository $userRepository,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        return $this->render('/members/list.html.twig', [
            'users' => $userRepository->findBy([], ['lastname' => Order::Ascending->value]),
        ]);
    }

    #[Route('/members/add', name: 'membersAdd')]
    public function add(
        Request $request,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);
        $dataForm = new AddUserFormData();

        $form = $this->createForm(AddUserType::class, $dataForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new AddUserCommand(
                $dataForm->firstName,
                $dataForm->lastName,
                $dataForm->email,
                $dataForm->birthday,
                $dataForm->licenseNumber,
                [$dataForm->role],
            );
            $this->commandBus->dispatch($command);
            $this->addFlash('success', 'Le nouveau membre est ajouté.');

            return $this->redirectToRoute('membersList');
        }

        return $this->render('/members/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
