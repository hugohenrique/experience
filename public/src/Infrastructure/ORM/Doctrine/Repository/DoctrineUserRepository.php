<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Repository;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class DoctrineUserRepository implements UserRepository
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository(User::class);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function findByCpf(string $cpf): ?User
    {
        return $this->repository->findOneBy(['cpf' => $cpf]);
    }

    public function findById(int $id): ?User
    {
        return $this->repository->find($id);
    }

    public function persist(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }
}
