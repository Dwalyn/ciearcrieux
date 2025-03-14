<?php

namespace App\Twig\Components\Administration\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class UserStatus
{
    use DefaultActionTrait;

    #[LiveProp(updateFromParent: true)]
    public User $user;

    #[LiveProp(writable: true, updateFromParent: true)]
    public bool $enable;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security,
    ) {
    }

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->enable = $this->user->isEnable();
    }

    #[LiveAction]
    public function changeEnable(): void
    {
        if ($this->security->getUser() !== $this->user) {
            $this->user->setEnable($this->enable);
            $this->entityManager->flush();
        } else {
            $this->enable = $this->user->isEnable();
        }
    }
}
