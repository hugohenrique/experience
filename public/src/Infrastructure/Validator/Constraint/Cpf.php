<?php
declare(strict_types=1);

namespace App\Infrastructure\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Cpf extends Constraint
{
    public $message = 'Informe um CPF válido';
}
