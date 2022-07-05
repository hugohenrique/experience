<?php
declare(strict_types=1);

namespace App\Shared\Application\Mailer;

final class Sender
{
    public function __construct(private string $name, private string $email)
    {
        $this->name  = $name;
        $this->email = $email;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}
