<?php

namespace App\Twig\Components;

use App\Entity\Post;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class PostComponent
{
    protected Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post;
    }

    public function getPost(): Post
    {
        return $this->post;
    }
}
