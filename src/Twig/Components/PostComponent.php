<?php

namespace App\Twig\Components;

use App\Entity\Post;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class PostComponent
{
    protected Post $post;
    public bool $hasTruncateDescription;

    public function mount(
        Post $post,
        bool $hasTruncateDescription = false,
    ): void {
        $this->post = $post;
        $this->hasTruncateDescription = $hasTruncateDescription;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getTruncateDescription(): string
    {
        return sprintf('%s ...', substr($this->post->getDescription(), 0, 300));
    }
}
