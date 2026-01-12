<?php

namespace App\Command\Post;

use App\Command\CommandInterface;
use App\Form\Datas\Actuality\PostFormData;

class NewPostCommand implements CommandInterface
{
    public function __construct(
        public readonly PostFormData $postFormData,
    ) {
    }
}
