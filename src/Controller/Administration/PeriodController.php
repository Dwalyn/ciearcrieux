<?php

namespace App\Controller\Administration;

use App\Command\CommandBusInterface;
use App\Command\LicensePeriod\UpdateLicensePriceCommand;
use App\Entity\LicensePeriod;
use App\Enum\RoleEnum;
use App\Factory\LicensePeriod\EditPriceFormDataFactory;
use App\Form\Type\LicensePeriod\EditPriceType;
use App\Repository\LicensePeriodRepository;
use App\Security\LicensePeriodVoter;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin', name: 'admin_')]
class PeriodController extends AbstractController
{
    #[Route('/periods', name: 'periodList')]
    public function list(
        LicensePeriodRepository $licensePeriodRepository,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        return $this->render('/administration/period/list.html.twig', [
            'licensePeriods' => $licensePeriodRepository->findBy([], ['endDate' => Order::Descending->value]),
        ]);
    }

    #[Route('/periods/{id}', name: 'periodDetails', requirements: ['id' => '\d+'])]
    public function details(
        LicensePeriod $licensePeriod,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        return $this->render('/administration/period/details.html.twig', [
            'licensePeriod' => $licensePeriod,
        ]);
    }

    #[Route('/periods/{id}/license', name: 'periodLicensePrice', requirements: ['id' => '\d+'])]
    public function price(
        LicensePeriod $licensePeriod,
        Request $request,
        EditPriceFormDataFactory $editPriceFormDataFactory,
        CommandBusInterface $commandBus,
        TranslatorInterface $translator,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);
        if (!$this->isGranted(LicensePeriodVoter::EDIT, $licensePeriod)) {
            $this->addFlash('danger', $translator->trans('alert.danger.unauthorizedEditLicensePeriod', [
                '%start%' => $licensePeriod->getStartDate()->format('Y'),
                '%end%' => $licensePeriod->getEndDate()->format('Y'),
            ]));

            return $this->redirectToRoute('admin_periodDetails', ['id' => $licensePeriod->getId()]);
        }

        $dataForm = $editPriceFormDataFactory->buildData($licensePeriod);
        $form = $this->createForm(EditPriceType::class, $dataForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->dispatch(new UpdateLicensePriceCommand($form->getData()));
            $this->addFlash('success', $translator->trans('alert.success.updateLicencePrice'));

            return $this->redirectToRoute('admin_periodDetails', ['id' => $licensePeriod->getId()]);
        }

        return $this->render('/administration/period/licensePrice.html.twig', [
            'licensePeriod' => $licensePeriod,
            'form' => $form->createView(),
        ]);
    }
}
