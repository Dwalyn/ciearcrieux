<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends AbstractFixture implements DependentFixtureInterface
{
    protected function buildEntity(array $data): Post
    {
        return new Post(
            $data['title'],
            $data['location'],
            $data['type'],
            (new \DateTime())->modify($data['postDate']),
            $data['description']
        );
    }

    public static function getReferenceName(): string
    {
        return 'post';
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
