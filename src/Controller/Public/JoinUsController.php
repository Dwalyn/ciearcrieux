<?php

namespace App\Controller\Public;

use App\Command\CommandBusInterface;
use App\Command\LicensePeriod\CheckLicensePeriodCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JoinUsController extends AbstractController
{
    #[Route('/join-us', name: 'joinUs')]
    public function joinUs(
        CommandBusInterface $commandBus
    ): Response {
        $commandBus->dispatch(new CheckLicensePeriodCommand());

        return $this->render('/joinUs/page.html.twig');
    }
}
