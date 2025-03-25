<?php

namespace App\Twig\Components\Administration\User;

use App\Command\CommandBusInterface;
use App\Command\User\AddUserCommand;
use App\Form\Type\User\AddUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class UserAdd extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    public function __construct(
        protected readonly CommandBusInterface $commandBus,
        protected readonly TranslatorInterface $translator,
    ) {
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(AddUserType::class);
    }

    #[LiveAction]
    public function validForm(): Response
    {
        $this->submitForm();

        $dataForm = $this->getForm()->getData();
        $command = new AddUserCommand(
            $dataForm->firstName,
            $dataForm->lastName,
            $dataForm->email,
            $dataForm->birthday,
            $dataForm->licenseNumber,
            [$dataForm->role],
        );
        $this->commandBus->dispatch($command);
        $this->addFlash('success', $this->translator->trans('alert.success.addMember'));

        return $this->redirectToRoute('admin_membersList');
    }
}
