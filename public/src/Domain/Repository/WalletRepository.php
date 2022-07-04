<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\User;
use App\Domain\Model\Wallet;

interface WalletRepository
{
    public function findByUser(User $user): ?Wallet;
    public function persist(Wallet $user): void;
}