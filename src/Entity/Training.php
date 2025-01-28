<?php

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\ORM\Table(name: 'training'), ORM\Entity()]
class Training
{
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true]), ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    public function __construct(){

    }

    public function getId(): ?int
    {
        return $this->id;
    }

}
