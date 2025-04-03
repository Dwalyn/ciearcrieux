<?php

namespace App\Controller\Administration;

use App\Entity\LicensePeriod;
use App\Enum\RoleEnum;
use App\Repository\LicensePeriodRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
