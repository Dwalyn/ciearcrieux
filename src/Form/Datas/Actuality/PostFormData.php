<?php

namespace App\Form\Datas\Actuality;

use App\Entity\Post;
use App\Enum\PostTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

class PostFormData
{
    #[Assert\NotNull()]
    public string $postTitle;

    #[Assert\NotNull()]
    public string $location;

    #[Assert\NotNull()]
    public ?string $content;

    #[Assert\NotNull()]
    public ?PostTypeEnum $postTypeEnum;

    #[Assert\NotNull()]
    public ?\DateTime $postDate;

    public function __construct(?Post $post)
    {
        if (null !== $post) {
            $this->postTitle = $post->getTitle();
            $this->location = $post->getLocation();
            $this->content = $post->getDescription();
            $this->postTypeEnum = $post->getPostTypeEnum();
            $this->postDate = $post->getPostDate();
        }
    }
}
