<?php
declare(strict_types=1);

namespace App\Application\Command;

final class RegisterUser
{
    public function __construct(
        private string $name,
        private string $cpf,
        private string $emailAddress,
        private string $password
    ) {
        $this->name         = $name;
        $this->cpf          = $cpf;
        $this->emailAddress = $emailAddress;
        $this->password     = $password;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function cpf(): string
    {
        return $this->cpf;
    }

    public function emailAddress(): string
    {
        return $this->emailAddress;
    }

    public function password(): string
    {
        return $this->password;
    }
}