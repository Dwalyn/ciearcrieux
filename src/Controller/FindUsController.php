<?php

namespace App\Controller;

use App\Enum\TypePlaceEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\EnumRequirement;

class FindUsController extends AbstractController
{
    #[Route('/find-us/{typePlace}', name: 'findUs', requirements: ['typePlace' => new EnumRequirement(TypePlaceEnum::class)])]
    public function findUs(TypePlaceEnum $typePlace): Response
    {
        return $this->render('/findUs/page.html.twig', [
            'typePlace' => $typePlace,
        ]);
    }
}
