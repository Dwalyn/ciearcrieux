<?php

namespace App\Form\Datas\Actuality;

use App\Enum\PostTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

class PostFormData
{
    #[Assert\NotNull()]
    public string $postTitle;

    #[Assert\NotNull()]
    public ?string $content;

    #[Assert\NotNull()]
    public ?PostTypeEnum $postTypeEnum;

    #[Assert\NotNull()]
    public ?\DateTime $postDate;
}
