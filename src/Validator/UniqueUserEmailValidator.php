<?php

namespace App\Validator;

use App\Domain\User\Action\CheckUserEmailExistsAction;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserEmailValidator extends ConstraintValidator
{
    public function __construct(private readonly CheckUserEmailExistsAction $checkUserEmailExistsAction)
    {
    }

    /**
     * @param UniqueUserEmail $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if ($this->checkUserEmailExistsAction->check($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
