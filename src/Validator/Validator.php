<?php

namespace App\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use App\Service\CheckDate;

class Validator extends ConstraintValidator
{
    private $checkDate;

    public function __construct(CheckDate $checkDate) {

        $this->checkDate = $checkDate;

    }

    public function validate($protocol, Constraint $constraint)
    {
        $new = new \DateTime();
        dump(date('w', $new->getTimestamp()));

        $reponse = $this->checkDate->getResponse($this->getDate());

        if /**(*/ ($reponse < 1000) /** && (date('w', $new->getTimestamp()) == date('w', $this->getDate()->getTimestamp()))) */ {
            $context->buildViolation('Le musée n\'a plus de place pour ce jour.')
                    ->atPath('date')
                    ->addViolation();
        }
    }
}