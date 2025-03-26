<?php

namespace App\Controller\Administration;

use App\Enum\RoleEnum;
use App\Repository\LicensePeriodRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_')]
class LicensePeriodController extends AbstractController
{
    #[Route('/license-periods', name: 'licensePeriodList')]
    public function list(
        LicensePeriodRepository $licensePeriodRepository,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        return $this->render('/administration/licensePeriod/list.html.twig', [
            'licensePeriods' => $licensePeriodRepository->findBy([], ['endDate' => Order::Descending->value]),
        ]);
    }
}
