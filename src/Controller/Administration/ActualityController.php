<?php

namespace App\Controller\Administration;

use App\Command\CommandBusInterface;
use App\Command\Post\NewPostCommand;
use App\Entity\Post;
use App\Enum\RoleEnum;
use App\Form\Datas\Actuality\PostFormData;
use App\Form\Type\Actuality\PostFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin', name: 'admin_')]
class ActualityController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $command,
        private readonly TranslatorInterface $translator,
    ) {
    }

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
        return $this->renderPostFormData($request);
    }

    #[Route('/post/edit/{id}', name: 'postEdit')]
    public function edit(
        Request $request,
        Post $post,
    ): Response {
        return $this->renderPostFormData($request, $post);
    }

    private function renderPostFormData(Request $request, ?Post $post = null): Response
    {
        $this->denyAccessUnlessGranted(RoleEnum::ROLE_ADMIN->value);

        $formData = new PostFormData($post);
        $form = $this->createForm(PostFormType::class, $formData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $post) {
                $this->command->dispatch(new NewPostCommand($form->getData()));
                $this->addFlash('success', $this->translator->trans('alert.success.newPost'));
            }

            return $this->redirectToRoute('admin_postsList');
        }

        return $this->render('/administration/post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
