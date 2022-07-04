<?php
declare(strict_types=1);

namespace App\Infrastructure\ExternalAuthorizer;

use App\Domain\Model\User;

class ExternalAuthorizerGateway
{
    public function authorize(User $user, float $value): void
    {
    }
}
