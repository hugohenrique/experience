<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\User;

interface UserRepository
{
    public function findByEmail(string $email): ?User;
    public function findByCpf(string $cpf): ?User;
    public function findById(int $id): ?User;
    public function persist(User $user): void;
}
