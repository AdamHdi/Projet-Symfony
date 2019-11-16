<?php

namespace App\Validator;

use App\Service\CheckDate;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class VisitorValidator extends ConstraintValidator
{
    private $checkdate;

    public function __construct(CheckDate $checkdate) {
        $this->checkdate= $checkdate;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\Visitor */

        $reponse = $this->checkdate->getResponse($value);

        if ($reponse > 1000) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value->format('Y-m-d'))
                ->addViolation();
        }
    }
}
