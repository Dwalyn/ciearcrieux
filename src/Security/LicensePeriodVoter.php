<?php

namespace App\Security;

use App\Entity\LicensePeriod;
use App\Enum\TimeStatusEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @extends Voter<string, LicensePeriodVoter>
 */
class LicensePeriodVoter extends Voter
{
    public const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof LicensePeriod) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        // you know $subject is a Post object, thanks to `supports()`
        /** @var LicensePeriod $licensePeriod */
        $licensePeriod = $subject;

        return match ($attribute) {
            self::EDIT => $this->canEdit($licensePeriod),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canEdit(LicensePeriod $licensePeriod): bool
    {
        return TimeStatusEnum::IN_PROGRESS === $licensePeriod->getStatus();
    }
}
