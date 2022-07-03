<?php
declare(strict_types=1);

namespace App\Domain\Exception;

use DomainException;

final class UserAlreadyExistsException extends DomainException
{
    public static function new(string $emailAddress): self
    {
        return new self(sprintf('This user %s already registered', $emailAddress));
    }
}
