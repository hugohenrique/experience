<?php
declare(strict_types=1);

namespace App\Infrastructure\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CpfValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // Code ported from jsfromhell.com
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            $this->context->addViolation($constraint->message, ['%string%' => $value]);
            return;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $this->context->addViolation($constraint->message, ['%string%' => $value]);
            return;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $this->context->addViolation($constraint->message, ['%string%' => $value]);
            return;
        }
    }
}