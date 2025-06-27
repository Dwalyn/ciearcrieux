<?php

namespace App\Entity;

use App\Enum\PostTypeEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'post'), ORM\Entity]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    protected ?string $id = null;

    #[ORM\Column(type: Types::STRING, length: 100)]
    protected string $title;

    #[ORM\Column(type: Types::STRING, length: 50)]
    protected string $location;

    #[ORM\Column(type: Types::STRING, length: 10, enumType: PostTypeEnum::class)]
    protected readonly PostTypeEnum $type;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    protected \DateTime $postDate;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    protected \DateTime $createdAt;

    #[ORM\Column(type: Types::TEXT)]
    protected string $description;

    public function __construct(
        string $title,
        string $location,
        PostTypeEnum $type,
        \DateTime $postDate,
        string $description,
    ) {
        $this->title = $title;
        $this->location = $location;
        $this->type = $type;
        $this->postDate = $postDate;
        $this->description = $description;
        $this->createdAt = new \DateTime();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPostDate(): \DateTime
    {
        return $this->postDate;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getPostTypeEnum(): PostTypeEnum
    {
        return $this->type;
    }
}
