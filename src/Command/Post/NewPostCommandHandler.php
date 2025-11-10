<?php

namespace App\Command\Post;

use App\Command\CommandHandlerInterface;
use App\Entity\Post;
use App\Enum\PostTypeEnum;
use Doctrine\ORM\EntityManagerInterface;

class NewPostCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(NewPostCommand $command): void
    {
        /**
         * @var string $title
         */
        $title = $command->postFormData->postTitle;
        /**
         * @var string $location
         */
        $location = $command->postFormData->location;
        /**
         * @var PostTypeEnum $type
         */
        $type = $command->postFormData->postTypeEnum;
        /**
         * @var \DateTime $date
         */
        $date = $command->postFormData->postDate;
        /**
         * @var string $content
         */
        $content = $command->postFormData->content;
        $content = str_replace('<p><br></p>', '', $content);
        $post = new Post($title, $location, $type, $date, $content);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}
