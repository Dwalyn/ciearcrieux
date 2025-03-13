<?php

namespace App\Twig\Components\Administration\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Order;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class UserSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $searchFilter = '';

    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    /**
     * @return array<User>
     */
    public function getUsers(): ?array
    {
        if ('' !== $this->searchFilter) {
            return $this->userRepository->findBySearchFilter($this->searchFilter);
        }

        return $this->userRepository->findBy([], ['lastname' => Order::Ascending->value]);
    }
}
