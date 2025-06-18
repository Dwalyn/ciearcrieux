<?php

namespace App\Controller\Administration;

use App\Command\CommandBusInterface;
use App\Command\LicensePeriod\EditTrainingCommand;
use App\Command\LicensePeriod\NewLicensePeriodCommand;
use App\Command\LicensePeriod\UpdateLicensePriceCommand;
use App\Command\LicensePeriod\UpdateRentPriceCommand;
use App\Entity\LicensePeriod;
use App\Entity\TrainingDay;
use App\Entity\TrainingPeriod;
use App\Enum\RoleEnum;
use App\Factory\LicensePeriod\Price\EditPriceFormDataFactory;
use App\Factory\LicensePeriod\Training\EditTrainingFormDataFactory;
use App\Form\Type\LicensePeriod\Price\EditLicensePriceType;
use App\Form\Type\LicensePeriod\Price\EditRentPriceType;
use App\Form\Type\LicensePeriod\Training\EditTrainingType;
use App\Repository\LicensePeriodRepository;
use App\Repository\TrainingPeriodRepository;
use App\Security\LicensePeriodVoter;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin', name: 'admin_')]
class PeriodController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly TranslatorInterface $translator,
        private readonly EditPriceFormDataFactory $editPriceFormDataFactory,
        private readonly EditTrainingFormDataFactory $editTrainingFormDataFactory,
    ) {
    }

    #[Route('/periods', name: 'periodList')]
    public function list(
        LicensePeriodRepository $licensePeriodRepository,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        return $this->render('/administration/period/list.html.twig', [
            'licensePeriods' => $licensePeriodRepository->findBy([], ['endDate' => Order::Descending->value]),
        ]);
    }

    #[Route('/periods/{id}', name: 'periodPriceDetails', requirements: ['id' => '\d+'])]
    public function pricedetails(
        LicensePeriod $licensePeriod,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        return $this->render('/administration/period/priceDetails.html.twig', [
            'licensePeriod' => $licensePeriod,
        ]);
    }

    #[Route('/periods/{id}/license', name: 'periodLicensePrice', requirements: ['id' => '\d+'])]
    public function price(
        LicensePeriod $licensePeriod,
        Request $request,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);
        $this->alertUnauthorizedEditPeriod($licensePeriod);

        $dataForm = $this->editPriceFormDataFactory->buildDataLicense($licensePeriod);
        $form = $this->createForm(EditLicensePriceType::class, $dataForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch(new UpdateLicensePriceCommand($form->getData()));
            $this->addFlash('success', $this->translator->trans('alert.success.updateLicencePrice'));

            return $this->redirectToRoute('admin_periodPriceDetails', ['id' => $licensePeriod->getId()]);
        }

        return $this->render('/administration/period/price.html.twig', [
            'licensePeriod' => $licensePeriod,
            'form' => $form->createView(),
            'h1' => 'license.licensePrice.h1',
        ]);
    }

    #[Route('/periods/{id}/rent', name: 'periodRentPrice', requirements: ['id' => '\d+'])]
    public function priceRent(
        LicensePeriod $licensePeriod,
        Request $request,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);
        $this->alertUnauthorizedEditPeriod($licensePeriod);

        $dataForm = $this->editPriceFormDataFactory->buildDataRent($licensePeriod);
        $form = $this->createForm(EditRentPriceType::class, $dataForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch(new UpdateRentPriceCommand($form->getData()));
            $this->addFlash('success', $this->translator->trans('alert.success.updateRentPrice'));

            return $this->redirectToRoute('admin_periodPriceDetails', ['id' => $licensePeriod->getId()]);
        }

        return $this->render('/administration/period/price.html.twig', [
            'licensePeriod' => $licensePeriod,
            'form' => $form->createView(),
            'h1' => 'license.rentPrice.h1',
        ]);
    }

    #[Route('/periods/create', name: 'periodCreate')]
    public function create(
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);
        $this->commandBus->dispatch(new NewLicensePeriodCommand());
        $this->addFlash('success', $this->translator->trans('alert.success.newPeriod'));

        return $this->redirectToRoute('admin_periodList');
    }

    #[Route('/periods/{id}/training', name: 'periodTraining', requirements: ['id' => '\d+'])]
    public function priceTraining(
        LicensePeriod $licensePeriod,
        TrainingPeriodRepository $trainingPeriodRepository,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);
        $trainingsInLicense = $trainingPeriodRepository->findTrainingPeriodInLicensePeriod($licensePeriod);

        return $this->render('/administration/period/trainingDetails.html.twig', [
            'licensePeriod' => $licensePeriod,
            'trainingsInLicense' => $trainingsInLicense,
        ]);
    }

    #[Route('/periods/training/edit/{id}', name: 'trainingEdit', requirements: ['id' => '\d+'])]
    public function editTraining(
        TrainingPeriod $trainingPeriod,
        Request $request,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        $dataForm = $this->editTrainingFormDataFactory->buildDataTraining($trainingPeriod);
        $form = $this->createForm(EditTrainingType::class, $dataForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch(new EditTrainingCommand($trainingPeriod, $dataForm));
            $this->addFlash('success', $this->translator->trans('alert.success.updateTrainingPeriod'));

            return $this->redirectToRoute('admin_periodTraining', ['id' => $trainingPeriod->getLicensePeriod()->getId()]);
        }

        return $this->render('/administration/period/trainingEdit.html.twig', [
            'licensePeriod' => $trainingPeriod->getLicensePeriod(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/periods/training-day/remove/{id}', name: 'trainingDayRemove', requirements: ['id' => '\d+'])]
    public function removeTrainingDay(
        TrainingDay $trainingDay,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        $trainingPeriod = $trainingDay->getTrainingPeriod();
        $this->addFlash('success', $this->translator->trans('alert.success.removeTrainingDay'));

        return $this->redirectToRoute('admin_trainingEdit', ['id' => $trainingPeriod->getId()]);
    }

    private function alertUnauthorizedEditPeriod(LicensePeriod $licensePeriod): ?RedirectResponse
    {
        if (!$this->isGranted(LicensePeriodVoter::EDIT, $licensePeriod)) {
            $this->addFlash('danger', $this->translator->trans('alert.danger.unauthorizedEditLicensePeriod', [
                '%start%' => $licensePeriod->getStartDate()->format('Y'),
                '%end%' => $licensePeriod->getEndDate()->format('Y'),
            ]));

            return $this->redirectToRoute('admin_periodDetails', ['id' => $licensePeriod->getId()]);
        }

        return null;
    }
}
