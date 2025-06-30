<?php

namespace App\Twig\Components\Administration\Actuality;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\Order;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class ListPostComponent
{
    public bool $showPaginator;
    public int $page;

    public function __construct(
        private PostRepository $postRepository,
        private PaginatorInterface $paginator,
    ) {
    }

    public function mount(bool $showPaginator = false, int $page = 1): void
    {
        $this->showPaginator = $showPaginator;
        $this->page = $page;
    }

    /**
     * @return array<int, Post>|PaginationInterface<int, mixed>
     */
    public function getListPost()
    {
        if ($this->showPaginator) {
            return $this->paginator->paginate(
                $this->postRepository->findBy([], ['postDate' => Order::Descending->value]),
                $this->page,
                10 /* limit per page */
            );
        }

        return $this->postRepository->findBy([], ['postDate' => Order::Descending->value], 5);
    }
}
