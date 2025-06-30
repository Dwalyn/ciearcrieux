<?php

namespace App\Controller\Administration;

use App\Enum\RoleEnum;
use App\Form\Datas\Actuality\PostFormData;
use App\Form\Type\Actuality\PostFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_')]
class ActualityController extends AbstractController
{
    #[Route('/post', name: 'postsList')]
    public function list(
        Request $request,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        return $this->render('/administration/post/list.html.twig', [
            'page' => $request->query->getInt('page', 1),
        ]);
    }

    #[Route('/post/add', name: 'postAdd')]
    public function add(
        Request $request,
    ): Response {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        $formData = new PostFormData();
        $form = $this->createForm(PostFormType::class, $formData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
            exit;
        }

        return $this->render('/administration/post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
