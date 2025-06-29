<?php

namespace App\Controller\Public;

use App\Form\Datas\Actuality\PostFormData;
use App\Form\Type\Actuality\PostFormType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ActualityController extends AbstractController
{
    #[Route('/actuality', name: 'actuality')]
    public function list(
        PostRepository $postRepository,
        Request $request,
    ): Response {
        $formData = new PostFormData();
        $form = $this->createForm(PostFormType::class, $formData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
            exit;
        }

        return $this->render(
            '/actuality/page.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
