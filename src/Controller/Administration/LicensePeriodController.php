<?php

namespace App\Controller\Administration;

use App\Command\CommandBusInterface;
use App\Enum\RoleEnum;
use App\Repository\LicensePeriodRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin', name: 'admin_')]
class LicensePeriodController extends AbstractController
{
    public function __construct(
        protected readonly CommandBusInterface $commandBus,
        protected readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/license-periods', name: 'licensePeriodList')]
    public function list(
        LicensePeriodRepository $licensePeriodRepository,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        return $this->render('/administration/licensePeriod/list.html.twig', [
            'licensePeriods' => $licensePeriodRepository->findBy([], ['id' => Order::Descending->value]),
        ]);
    }
}
