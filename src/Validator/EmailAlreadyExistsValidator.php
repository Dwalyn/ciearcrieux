<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class EmailAlreadyExistsValidator extends ConstraintValidator
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof EmailAlreadyExists) {
            throw new UnexpectedTypeException($constraint, EmailAlreadyExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (null !== $this->userRepository->findOneBy(['email' => $value])) {
            $this->context->buildViolation($constraint->message)
                ->addViolation()
            ;
        }
    }
}
