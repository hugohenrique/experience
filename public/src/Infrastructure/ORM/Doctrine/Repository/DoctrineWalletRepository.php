<?php
declare(strict_types=1);

namespace App\Infrastructure\ORM\Doctrine\Repository;

use App\Domain\Model\User;
use App\Domain\Model\Wallet;
use App\Domain\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class DoctrineWalletRepository implements WalletRepository
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository(User::class);
    }

    public function findByUser(User $user): ?Wallet
    {
        return $this->repository->findOneBy(['user' => $user]);
    }

    public function persist(Wallet $wallet): void
    {
        $this->em->persist($wallet);
        $this->em->flush();
    }
}
