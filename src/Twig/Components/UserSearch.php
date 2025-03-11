<?php

namespace App\Twig\Components;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Order;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent]
class UserSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $lastname = '';

    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    public function getUsers(): ?array
    {
        if('' !== $this->lastname) {
            return $this->userRepository->findBy(['lastname' => $this->lastname], ['lastname' => Order::Ascending->value]);
        }
        return $this->userRepository->findBy([], ['lastname' => Order::Ascending->value]);
    }
}
